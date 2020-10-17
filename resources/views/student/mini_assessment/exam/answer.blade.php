<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>question - #123</title>

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

        .information table {
            padding: 10px;
        }

        .container {
            padding: 32px;
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
    </style>

</head>

<body>
    <div class="container">
        <div class="information pb-32">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 60%;">
                        <div id="title1" class="font-3 color-grey pb-2">{{$task['mini_assessment']['group']}}</div>
                        <div id="title2" class="font-4 color-black pb-6">{{$subject}}</div>
                        <div class="font-1 color-grey-5">{{ $task['mini_assessment']['id'] }}</div>
                    </td>
                    <td align="right" style="width: 40%;">
                        <div class="box">
                            <div class="font-2 color-black pb-6">{{ $userable['name'] }}</div>
                            <div class="font-3 color-grey">{{ $userable['nis'] }} | {{ $userable['class_name'] }}</div>
                        </div>
                    </td>
                </tr>

            </table>
        </div>
        <div class="pb-32">
            <div class="box-2 font-1">Dokumen ini bersifat pribadi dan rahasia. Dilarang menyerahkan dokumen ini kepada orang lain tanpa petunjuk guru. Simpan dokumen ini baik-baik sebagai bukti keikutsertaan penilaian.</div>
        </div>
        <div class="question pb-32">
            @php
            $collected = collect($task['answers']);
            $collectionPG = $collected->filter(function ($value, $key) {
            return !is_array($value['answer']);
            });
            $collectionCheck = $collected->filter(function ($value, $key) {
            return is_array($value['answer']);
            });
            $divider = (float) ($collectionPG->count() / 4);
            $divider = ceil($divider);
            $divider2 = (float) ($collectionCheck->count() / 2);
            $divider2 = ceil($divider2);
            $countPg = ceil((float) ($collectionPG->count()));
            @endphp
            <div class="font-5 color-black">Pilihan Ganda </div>
            <table width="100%" class="tbl font-3">
                <tr>
                    <td>
                        <table>
                            @foreach ($task['answers'] as $t)
                            @if (($loop->index + 1) <= $divider && !is_array($t['answer'])) <tr style="height: 8px;">
                                <td class="td-answer">{{ $loop->index + 1 }}</td>
                                @php
                                $maAnswerId = $t['id'];
                                @endphp
                                <td class="pl-16">{{ $answers[$maAnswerId]['answer'] }}</td>
                </tr>
                @endif
                @endforeach
            </table>
            </td>
            <td>
                <table>
                    @foreach ($task['answers'] as $t)
                    @if (($loop->index + 1) > ($divider * 1) && ($loop->index + 1) <= ($divider * 2) && !is_array($t['answer'])) <tr style="height: 8px;">
                        <td class="td-answer">{{ $loop->index + 1 }}</td>
                        @php
                        $maAnswerId = $t['id'];
                        @endphp
                        <td class="pl-16">{{ $answers[$maAnswerId]['answer'] }}</td>
                        </tr>
                        @endif
                        @endforeach
                </table>
            </td>
            <td>
                <table>
                    @foreach ($task['answers'] as $t)
                    @if (($loop->index + 1) > ($divider * 2) && ($loop->index + 1) <= ($divider * 3) && !is_array($t['answer'])) <tr style="height: 8px;">
                        <td class="td-answer">{{ $loop->index + 1 }}</td>
                        @php
                        $maAnswerId = $t['id'];
                        @endphp
                        <td class="pl-16">{{ $answers[$maAnswerId]['answer'] }}</td>
                        </tr>
                        @endif
                        @endforeach
                </table>
            </td>
            <td>
                <table>
                    @foreach ($task['answers'] as $t)
                    @if (($loop->index + 1) > ($divider * 3) && !is_array($t['answer']))
                    <tr style="height: 8px;">
                        <td class="td-answer">{{ $loop->index + 1 }}</td>
                        @php
                        $maAnswerId = $t['id'];
                        @endphp
                        <td class="pl-16">{{ $answers[$maAnswerId]['answer'] }}</td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            </td>
            </tr>
            </table>
        </div>
        @php
            $collectionForCheck = $collected->filter(function ($value, $key) {
                return is_array($value['answer']);
            });
        @endphp
        @if ($collectionForCheck->count() > 0)
        <div class="question">
            <div class="font-5 color-black">Menceklis Daftar</div>
            <table width="100%" class="tbl font-3">
                <tr>
                    <td>
                        <table>
                        @foreach ($task['answers'] as $t)
                        @if (($loop->index + 1) > $countPg && ($loop->index + 1) <= ($divider2 + $countPg) && is_array($t['answer']))
                            <tr style="height: 8px;">
                                <td class="td-answer">{{ $loop->index + 1 }}</td>
                                @php
                                $maAnswerId = $t['id'];
                                @endphp
                                @if ($answers[$maAnswerId]['answer'] !== null)
                                @foreach ($answers[$maAnswerId]['answer'] as $a)
                                <td class="pl-16">{{$a}}</td>
                                @endforeach
                                @endif
                            </tr>
                        @endif
                        @endforeach
            </table>
            </td>
            <td>
                <table>
                    @foreach ($task['answers'] as $t)
                    @if (($loop->index + 1) > ($divider2 + ($countPg)) && ($loop->index + 1) <= ($divider2 + ($countPg * 2)) && is_array($t['answer'])) <tr style="height: 8px;">
                        <td class="td-answer">{{ $loop->index + 1 }}</td>
                        @php
                        $maAnswerId = $t['id'];
                        @endphp
                        @if ($answers[$maAnswerId]['answer'] !== null)
                        @foreach ($answers[$maAnswerId]['answer'] as $a)
                        <td class="pl-16">{{$a}}</td>
                        @endforeach
                        @endif
                        </tr>
                        @endif
                        @endforeach
                </table>
            </td>
            </tr>
            </table>
        </div>
    </div>
    @endif
    <div class="footer" style="position: absolute; bottom: 0;">
        <table width="100%">
            <tr>
                <td align="left" style="width: 30%;">
                    <div class="font-1 color-grey-5">Halaman 1 dari 1</div>

                </td>
                <td align="right" style="width: 70%;">
                    <div class="font-1 color-grey-5"><i>{{ $userable['name'] }} ({{ $userable['nis'] }}, {{ $userable['class_name'] }})</i></div>
                    <div class="font-1 color-grey-5"><i>Diunduh pada pukul {{ $time ?? '' }}, {{ $date ?? '' }} dari Kejar.id.</i></div>
                </td>
            </tr>

        </table>
    </div>
</body>

<script>
    $('#title2').html(localStorage.getItem('detail_title') || '');
    $('#title1').html(localStorage.getItem('pts_title') || '');
</script>

</html>
