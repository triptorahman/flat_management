<x-mail::message>
@if($recipientType === 'tenant')
# Payment Received - Thank You!

Hello {{ $tenant->name }},

We have successfully received your payment for the bill of **{{ $bill->flat->flat_number }}** for **{{ date('F Y', strtotime($bill->month)) }}**.

@elseif($recipientType === 'house_owner')
# Bill Payment Collected

Hello {{ $bill->houseOwner->name }},

Payment has been successfully collected for **Flat {{ $bill->flat->flat_number }}** from tenant **{{ $tenant->name }}**.

@else
# Bill Payment Notification

Hello Admin,

A bill payment has been collected in the system.

@endif

## Payment Details

**Tenant:** {{ $tenant->name }}  
**Flat:** {{ $bill->flat->flat_number }}  
**Bill Month:** {{ date('F Y', strtotime($bill->month)) }}  
**Payment Date:** {{ date('l, F j, Y', strtotime($paymentDate)) }}  
**Amount Paid:** ${{ number_format($totalPaidAmount, 2) }}  

## Bill Breakdown

**Current Bill Amount:** ${{ number_format($bill->amount, 2) }}
@if($includedDueAmount)
**Previous Due Amount:** ${{ number_format($totalPaidAmount - $bill->amount, 2) }}  
**Total Amount Paid:** ${{ number_format($totalPaidAmount, 2) }}
@else
**Total Amount Paid:** ${{ number_format($bill->amount, 2) }}
@endif

## Bill Categories

@foreach($bill->billDetails as $detail)
- **{{ $detail->billCategory->name }}**: ${{ number_format($detail->amount, 2) }}
  @if($detail->description)
  <br>*{{ $detail->description }}*
  @endif
@endforeach

@if($bill->notes)
## Additional Notes
{{ $bill->notes }}
@endif

@if($recipientType === 'tenant')
@if($includedDueAmount)
<x-mail::panel>
**Great News!** This payment includes your previous due amount. Your account is now fully up to date.
</x-mail::panel>
@endif

## Payment Receipt

This email serves as your payment receipt. Please keep this for your records.

**Transaction Status:** Completed  
**Payment Method:** As recorded by house owner  
**Next Bill:** Expected for {{ date('F Y', strtotime($bill->month . ' +1 month')) }}

Thank you for your prompt payment!

@elseif($recipientType === 'house_owner')
## Collection Summary

@if($includedDueAmount)
- ✅ Current month bill: **PAID**
- ✅ Previous due amounts: **CLEARED**
- ✅ Account status: **UP TO DATE**
@else
- ✅ Current month bill: **PAID**
- ⚠️ Previous due amounts: **Still pending** (if any)
@endif

The tenant's payment has been successfully processed and recorded in the system.

@else
## Admin Summary

**House Owner:** {{ $bill->houseOwner->name }}  
**Building:** {{ $bill->flat->building->name ?? 'N/A' }}  
**Collection Date:** {{ date('l, F j, Y \a\t g:i A', strtotime($paymentDate)) }}  
**Status:** Payment successfully recorded

@endif

@if($recipientType === 'tenant')
Best regards,<br>
{{ $bill->houseOwner->name }}<br>
Property Management
@elseif($recipientType === 'house_owner')
Best regards,<br>
{{ config('app.name') }}<br>
Property Management System
@else
Best regards,<br>
{{ config('app.name') }}<br>
System Administrator
@endif
</x-mail::message>
