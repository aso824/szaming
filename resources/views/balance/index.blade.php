@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Who owes you') }}</div>
                    <div class="card-body">
                        @forelse ($balanceViewModel->getDebts() as $debtor)
                            @php /** @var \App\Models\User $debtor */ @endphp

                            @if ($loop->first)
                                  <ul>
                            @endif
                                      <li>
                                          {{ $debtor->name }}: <span class="font-weight-bold text-success">{{ $balanceViewModel->formatPrice($debtor->pivot->amount) }}</span>
                                      </li>
                            @if ($loop->last)
                                  </ul>
                            @endif
                        @empty
                            {{ __('No one owes you :(') }}
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('To whom you owe') }}</div>
                    <div class="card-body">
                        @forelse ($balanceViewModel->getCredits() as $credit)
                            @php /** @var \App\Models\User $credit */ @endphp

                            @if ($loop->first)
                                  <ul>
                            @endif
                                      <li>
                                          {{ $credit->name }}: <span class="font-weight-bold text-danger">-{{ $balanceViewModel->formatPrice($credit->pivot->amount) }}</span>
                                      </li>
                            @if ($loop->last)
                                  </ul>
                            @endif
                        @empty
                            {{ __('You don\'t owe anyone :)') }}
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
