@php
    $tpStart = date('Y');
    $tpEnd = date('Y', strtotime('+1 years'));
    $tp = $tpStart . ' - ' . $tpEnd;
@endphp
<div class="col-12">
    <div class="content-header">
        <h1 class="content-title">Penilaian TP {{ $academicYear }}</h1>
    </div>
    <div id="assessment-teacher" class="content-body">
        <div id="data-assessment">
            <!-- Let it Empty -->
            <!-- Will Added later on Javascript Process -->
        </div>
        @php
            $roles = session('user.userable.roles');
            $isCurriculum = in_array('CURRICULUM', $roles);
        @endphp
        @if($isCurriculum)
        <div id="pts-tambah"class="card-pts mt-4">
            <h3 class="text-reguler text-blue">
                <i class="kejar-add text-blue mr-4"></i>
                <span>Tambah Kelompok Penilaian</span>
            </h3>
        </div>
        @endif
    </div>
</div>
