<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Answer Sheet</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        p {
            margin-bottom: 0px;
            margin-top: 0px;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .question h3 {
            margin-left: 15px;
        }

        .container {
            padding: 32px;
        }

        .pt-8 {
            padding-top: 8px;
        }

        .pt-48 {
            padding-top: 48px;
        }

        .pb-32 {
            padding-bottom: 32px;
        }

        .pb-16 {
            padding-bottom: 16px;
        }

        .pl-16 {
            padding-left: 16px;
        }

        .pl-8 {
            padding-left: 8px;
        }

        .pb-8 {
            padding-bottom: 8px;
        }

        .pb-6 {
            padding-bottom: 6px;
        }

        .pb-4 {
            padding-bottom: 2px;
        }

        .box {
            padding: 10px 14px;
            width: 100%;
            border: 1px #ABBED4 solid;
            text-align: left;
        }

        .box-2 {
            padding: 10px 12px;
            width: 100%;
            background-color: #FBFBFB;
            text-align: left;
        }

        .tbl {
            padding: 16px;
        }

        .td-answer {
            width: 10%;
            text-align: right;
        }

        .td-number {
            width: 24px;
            text-align: right;
        }

        .color-grey {
            color: #334E68;
        }

        .color-black {
            color: #202020;
        }

        .color-grey-5 {
            color: #627D98;
        }


        .font-3 {
            font-family: Roboto Mono;
            font-style: normal;
            font-weight: normal;
            font-size: 16px;
            line-height: 20px;
        }

        .font-5 {
            font-family: Roboto Mono;
            font-style: normal;
            font-weight: bold;
            font-size: 16px;
            line-height: 20px;
        }

        .font-4 {
            font-family: Roboto Mono !important;
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 20px;
        }

        .font-1 {
            font-family: Roboto Mono;
            font-style: normal;
            font-weight: normal;
            font-size: 13px;
            line-height: 16px;
        }

        .font-2 {
            font-family: Roboto Mono;
            font-style: normal;
            font-weight: normal;
            font-weight: 500;
            font-size: 16px;
            line-height: 20px;
        }

        .center {
            text-align: center;
        }

        .footer {
            padding-left: 32px;
            padding-right: 32px;
            padding-bottom: 24px;
        }

        .page_break {
            page-break-before: always;
        }

    </style>

</head>

<body>
    <div class="container">
        <div class="pb-32">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 60%;">
                        <div id="title1" class="font-3 color-grey pb-2">{{ $group }}</div>
                        <div id="title2" class="font-4 color-black pb-6">{{ $subject }}</div>
                        <div class="font-1 color-grey-5">{{ $task['assessment']['id'] }}</div>
                    </td>
                    <td align="right" style="width: 40%;">
                        <div class="box">
                            <div class="font-2 color-black pb-6">{{ $userable['name'] }}</div>
                            <div class="font-3 color-grey">{{ $userable['nis'] }} | {{ $userable['student_group']['name'] }}</div>
                        </div>
                    </td>
                </tr>

            </table>
        </div>
        <div class="pb-32">
            <div class="box-2 font-1">Dokumen ini bersifat pribadi dan rahasia. Dilarang menyerahkan dokumen ini kepada orang lain tanpa petunjuk guru. Simpan dokumen ini baik-baik sebagai bukti keikutsertaan penilaian.</div>
        </div>
        @php
            $collected = collect($task['assessment']['questions']);

            $total = $collected->count();
            $page = 1;
            $nextPage = $total - 1;
            $lastPage = true;
            $j = 0;
            $hasNextPage = $total > 25;
            if ($hasNextPage) {
                $page += 1;
                $nextPage = 24;
                $lastPage = false;
            }
        @endphp
        @for($i = 0; $i <= $page - 1; $i ++)
        <div class="question pb-32">
            @if ($i === 0)
            <div class="font-5 color-black">Lembar Jawaban</div>
            @endif
            <table class="{{ $i === 0 ? 'pt-8' : 'pt-48' }}">
                @for ($j; $j <= $nextPage; $j++)
                <tr>
                    <td class="td-number pt-8">{{ $j + 1 }}</td>
                    @php
                        $maAnswerId = $collected[$j]['id'];
                        $answer = $answers[$maAnswerId]['answer'];
                    @endphp
                    <td class="pl-16 pt-8">{{ $answer }}.</td>
                    <td class="pl-8 pt-8">{!! $collected[$j]['choices'][$answer] !!}</td>
                </tr>
                @endfor
            </table>
        </div>
        <div class="footer" style="position: absolute; bottom: 0;">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 30%;">
                        <div class="font-1 color-grey-5">Halaman {{ $i + 1 }} dari {{ $page }}</div>
                    </td>
                    <td align="right" style="width: 70%;">
                        <div class="font-1 color-grey-5"><i>{{ $userable['name'] }} ({{ $userable['nis'] }}, {{ $userable['student_group']['name'] }})</i></div>
                        <div class="font-1 color-grey-5"><i>Diunduh pada pukul {{ $time ?? '' }}, {{ $date ?? '' }} dari Kejar.id.</i></div>
                    </td>
                </tr>
            </table>
        </div>
        @if ($hasNextPage && !$lastPage)
            @php
                $lastPage = true;
                $j = $nextPage + 1;
                $remaining = ($total - 1) - 24;
                $nextPage += $remaining;
            @endphp
            <div class="page_break"></div>
        @endif
        @endfor
    </div>
</body>

<script>
    $('#title2').html(localStorage.getItem('detail_title') || '');
    $('#title1').html(localStorage.getItem('pts_title') || '');
</script>

</html>
