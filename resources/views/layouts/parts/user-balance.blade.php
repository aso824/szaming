<li class="nav-item">
    <a href="{{ route('balance.index') }}" class="
        nav-link font-initial
        @if ($balance !== 0.0)
            font-weight-bold
            @if ($balance > 0)
                text-success
            @else
                text-danger
            @endif
        @endif
    " title="{{ __('Balance of your debts and receivables') }}">
        {{ $balance }}
    </a>
</li>
