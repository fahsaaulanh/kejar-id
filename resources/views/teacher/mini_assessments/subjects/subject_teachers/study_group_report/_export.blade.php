<?php
    // style
    $styleHeader = "vertical-align:middle; text-align:center; background-color:#d9d9d9; border: 1px solid black;";
    $styleBorder = "border: 1px solid black;";
?>
<table border="1" width="100%">
    <thead>
        <tr>
            <td colspan="2">
                <strong>Daftar Nilai Siswa</strong>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Rombel</strong>
            </td>
            <td>
                {{$data['StudentGroupDetail']['name']}}
            </td>
        </tr>
        <tr>
            <td>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                *Untuk melihat naskah soal, silakan login terlebih dahulu pada web matrikulasi.kejar.id menggunakan username yang telah diberikan.
            </td>
        </tr>
        <!-- Menggunakan cara style class belum berfungsi jadi code dibuat inline style dulu untuk sementara -->
        <tr>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>Nama</strong>
            </th>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>NIS</strong>
            </th>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>Paket</strong>
            </th>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>Link Soal</strong>
            </th>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>Waktu Mulai</strong>
            </th>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>Waktu Selesai</strong>
            </th>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>Durasi</strong>
            </th>
            <th colspan="3" style="{{$styleHeader}}">
                <strong>Pilihan Ganda</strong>
            </th>
            <th colspan="5" style="{{$styleHeader}}">
                <strong>Menceklis Daftar</strong>
            </th>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>Nilai Rekomendasi</strong>
            </th>
            <th rowspan="2" style="{{$styleHeader}}">
                <strong>Nilai Akhir</strong>
            </th>
        </tr>

        <tr>
            <td style="{{$styleHeader}}">
                Benar
            </td>
            <td style="{{$styleHeader}}">
                Salah
            </td>
            <td style="{{$styleHeader}}">
                Tidak
                 Diisi</td>
            <td style="{{$styleHeader}}">
                Pilihan
            </td>
            <td style="{{$styleHeader}}">
                Jawaban
            </td>
            <td style="{{$styleHeader}}">
                Benar
            </td>
            <td style="{{$styleHeader}}">
                Tidak
                 Terjawab</td>
            <td style="{{$styleHeader}}">
                Salah
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach($data['data'] as $key => $v)
            @if($v['finished'])
                <tr>
                    <td style="{{ $styleBorder }}" align="left">{{ $v['name'] }}</td>
                    <td style="{{ $styleBorder }}" align="left">{{ $v['nis'] }}</td>
                    <td style="{{ $styleBorder }}">{{ $v['mini_assessment']['title'] }}</td>
                    <td style="{{ $styleBorder }}">
                        <a href="{{ $v['mini_assessment']['pdf'] }}" target="_blank">
                            {{ $v['mini_assessment']['title'] }}
                        </a>
                    </td>
                    <td style="{{ $styleBorder }}">{{ \Carbon\Carbon::parse($v['score']['start_time'])->format('d, M Y H:i') }}</td>
                    <td style="{{ $styleBorder }}">{{ \Carbon\Carbon::parse($v['score']['finish_time'])->format('d, M Y H:i') }}</td>
                    <td style="{{ $styleBorder }}">{{ \Carbon\Carbon::parse( $v['score']['start_time'] )
                                ->diffInMinutes( $v['score']['finish_time'] ) }} Menit</td>

                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['pg']['correct'] }}</td>
                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['pg']['wrong'] }}</td>
                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['pg']['miss'] }}</td>

                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['cq']['total_choices'] ?? '' }}</td>
                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['cq']['correct_answer'] }}</td>
                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['cq']['correct'] }}</td>
                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['cq']['miss'] }}</td>
                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['cq']['wrong'] }}</td>

                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['recommendation_score'] }}</td>
                    <td style="{{ $styleBorder }}" align="center">{{ $v['score']['score']['final_score'] ?? 'Belum ada nilai' }}</td>
                </tr>
            @else
                <tr>
                    <td style="{{ $styleBorder }}" align="left">{{ $v['name'] }}</td>
                    <td style="{{ $styleBorder }}" align="left">{{ $v['nis'] }}</td>
                    <td style="{{ $styleBorder }}" colspan='15'>Belum mengerjakan</td>
                </tr>
            @endif()
        @endforeach()
    </tbody>
</table>
