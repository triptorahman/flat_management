<x-mail::message>
# New Bill Generated

Hello {{ $tenant->name }},

A new bill has been generated for your flat **{{ $bill->flat->flat_number }}** for the month of **{{ date('F Y', strtotime($bill->month)) }}**.

## Bill Details

**Flat:** {{ $bill->flat->flat_number }}  
**Month:** {{ date('F Y', strtotime($bill->month)) }}  
**Current Bill Amount:** ${{ number_format($bill->amount, 2) }}  
@if($dueAmount > 0)
**Previous Due Amount:** ${{ number_format($dueAmount, 2) }}  
**Total Amount Due:** ${{ number_format($bill->amount + $dueAmount, 2) }}
@else
**Total Amount Due:** ${{ number_format($bill->amount, 2) }}
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

## Payment Information

Please make your payment at your earliest convenience. You can contact your house owner for payment methods and details.

**Status:** {{ ucfirst($bill->status) }}  
**Generated on:** {{ $bill->created_at->format('l, F j, Y \a\t g:i A') }}

@if($dueAmount > 0)
<x-mail::panel>
**Important:** You have a previous due amount of ${{ number_format($dueAmount, 2) }}. Please consider paying the full amount to avoid accumulating charges.
</x-mail::panel>
@endif

Thank you for your attention to this matter.

Best regards,<br>
{{ $bill->houseOwner->name }}<br>
Property Management
</x-mail::message>
