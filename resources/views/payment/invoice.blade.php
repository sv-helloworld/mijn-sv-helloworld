<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('/css/pdf.css') }}" type="text/css">
    </head>
    <body>
        <div>
            <table>
                <tr>
                    <td width="60%">
                        <div class="hw-h3 margin-small">Factuur</div>

                        <div class="margin">
                            <table>
                                <tr>
                                    <td width="90">Factuurdatum:</td>
                                    <td>@date($payment->paid_at)</td>
                                </tr>
                                <tr>
                                    <td width="90">Factuurnummer:</td>
                                    <td>{{ $payment->id }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="margin">
                            {{ $payment->user->full_name() }}<br>
                            {{ $payment->user->address }}<br>
                            {{ $payment->user->zip_code }} {{ $payment->user->city }}
                        </div>
                    </td>
                    <td width="40%">
                        <div class="margin">
                            <img src="{{ asset('/images/logo@2x.png') }}" width="auto" height="40px" />
                        </div>

                        <div class="margin">
                            <strong>Studievereniging "Hello World"</strong><br>
                            Edisonweg 4, Vlissingen (Nederland)
                        </div>

                        <div class="margin">
                            E-mail: info@svhelloworld.nl
                        </div>

                        <div class="margin">
                            IBAN: NL96 INGB 0007 3146 14<br>
                            BIC: INGBNL2A
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="margin">
            <table class="table table-striped" width="100%">
                <thead>
                    <tr>
                        <th width="40">Aantal</th>
                        <th>Omschrijving</th>
                        <th width="60" class="text-right">Tarief</th>
                        <th width="60" class="text-right">Totaal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $payment->description }}</td>
                        <td class="text-right">&euro; {{ $payment->amount }}</td>
                        <td class="text-right">&euro; {{ $payment->amount }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td class="text-right"><strong>Totaalbedrag:</strong></td>
                        <td class="text-right">&euro; {{ $payment->amount }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="hr"></div>

        <div class="padding">
            Voor vragen kunt u contact opnemen per e-mail.
        </div>
    </body>
</html>
