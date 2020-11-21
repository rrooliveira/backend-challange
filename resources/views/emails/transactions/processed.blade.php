@component('mail::message')
    # Você recebeu uma nova transferência de pagamento!!!

    Você recebeu uma transferência do Sr(a). {{ $payer->name }} enviou o valor de R$ {{ number_format($value,2,',','.') }}.

    Este valor está disponível em sua carteira.

    Obrigado,
    Desafio Backend!!!
@endcomponent
