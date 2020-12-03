@extends('layout.index')

@section('title', 'Exam')

@section('header-exam')
@show

@section('content')
<div class="container-exam">
    <div id="drawer" class="drawer-exam d-flex-column">
        <div class="row m-0">
            <h5>Daftar Soal</h5>
        </div>
        <div class="container-list-number">
            <div class="list-number selected" role="button" onclick="myFunction()">
                1
            </div>
            <div class="list-number active" role="button" onclick="myFunction()">
                2
            </div>
            <div class="list-number selected active" role="button" onclick="myFunction()">
                3
            </div>
            <div class="list-number">
                4
            </div>
            <div class="list-number">
                5
            </div>
            <div class="list-number">
                6
            </div>
            <div class="list-number">
                7
            </div>
            <div class="list-number">
                8
            </div>
            <div class="list-number">
                9
            </div>
            <div class="list-number">
                10
            </div>
            <div class="list-number">
                1
            </div>
            <div class="list-number">
                2
            </div>
            <div class="list-number">
                3
            </div>
            <div class="list-number">
                4
            </div>
            <div class="list-number">
                5
            </div>
            <div class="list-number">
                6
            </div>
            <div class="list-number">
                7
            </div>
            <div class="list-number">
                8
            </div>
            <div class="list-number">
                9
            </div>
            <div class="list-number">
                10
            </div>
            <div class="list-number">
                1
            </div>
            <div class="list-number">
                2
            </div>
            <div class="list-number">
                3
            </div>
            <div class="list-number">
                4
            </div>
            <div class="list-number">
                5
            </div>
            <div class="list-number">
                6
            </div>
            <div class="list-number">
                7
            </div>
            <div class="list-number">
                8
            </div>
            <div class="list-number">
                9
            </div>
            <div class="list-number">
                10
            </div>
            <div class="list-number">
                1
            </div>
            <div class="list-number">
                2
            </div>
            <div class="list-number">
                3
            </div>
            <div class="list-number">
                4
            </div>
            <div class="list-number">
                5
            </div>
            <div class="list-number">
                6
            </div>
            <div class="list-number">
                7
            </div>
            <div class="list-number">
                8
            </div>
            <div class="list-number">
                9
            </div>
            <div class="list-number">
                10
            </div>
            <div class="list-number">
                1
            </div>
            <div class="list-number">
                2
            </div>
            <div class="list-number">
                3
            </div>
            <div class="list-number">
                4
            </div>
            <div class="list-number">
                5
            </div>
            <div class="list-number">
                6
            </div>
            <div class="list-number">
                7
            </div>
            <div class="list-number">
                8
            </div>
            <div class="list-number">
                9
            </div>
            <div class="list-number">
                10
            </div>
        </div>
    </div>
    <div class="content-exam">
        <div>
            <div class="assesment-btn-question" role="button" onclick="toggleDrawer()">
                <i class="kejar-right"></i>
                <h5>Lihat Daftar Soal</h5>
            </div>
        </div>
        <div>
            <h4>SOAL 1 <span class="text-grey-6">/ 50</span></h4>
            <p class="pt-2">Pilih “benar” atau “salah” untuk setiap pernyataan yang diberikan!</p>
        </div>
        <div class="assessment-question">
            <p>
                Bacalah wacana di bawah ini dengan saksama!

                (1) Objek wisata Pantai Mutun menyediakan transportasi untuk memudahkan wisatawan menikmati keindahan pantai.
                (2) Wisatawan domestik maupun mancanegara dapat menggunakan transportasi untuk menikmati keindahan alam sekitar Pantai Mutun.
                (3) Di sepanjang pantai berjejer perahu untuk disewakan dengan biaya Rp10.000,00 saja per orangnya.
                (4) Para wisatawan pun dapat berputar di sekitar seberang Pulau Pantai Mutun.
                (5) Para pedagang pun ikut meramaikan pantai itu.

                Kalimat penjelas yang sumbang dalam paragraf tersebut ditandai dengan nomor ...
            </p>
        </div>

        <div class="row m-0 d-flex flex-column">
            <div class="row m-0 align-items-center pt-6">
                <div class="choice-group-a mb-2 mb-md-0 mb-lg-0 mb-xl-0 ml-0 assessment-choice">
                    <span>A</span>
                </div>
                <div class="ml-4">
                    Kalimat (1)
                </div>
            </div>
            <div class="row m-0 align-items-center pt-6">
                <div class="choice-group-a mb-2 mb-md-0 mb-lg-0 mb-xl-0 ml-0 assessment-choice">
                    <span>B</span>
                </div>
                <div class="ml-4">
                    Kalimat (2)
                </div>
            </div>
            <div class="row m-0 align-items-center pt-6">
                <div class="choice-group-a mb-2 mb-md-0 mb-lg-0 mb-xl-0 ml-0 assessment-choice">
                    <span>C</span>
                </div>
                <div class="ml-4">
                    Kalimat (3)
                </div>
            </div>
            <div class="row m-0 align-items-center pt-6">
                <div class="choice-group-a mb-2 mb-md-0 mb-lg-0 mb-xl-0 ml-0 assessment-choice">
                    <span>D</span>
                </div>
                <div class="ml-4">
                    Kalimat (4)
                </div>
            </div>
            <div class="row m-0 align-items-center pt-6">
                <div class="choice-group-a mb-2 mb-md-0 mb-lg-0 mb-xl-0 ml-0 assessment-choice">
                    <span>E</span>
                </div>
                <div class="ml-4">
                    Kalimat (5)
                </div>
            </div>
        </div>

        <div class="row m-0 content-footer">
            <div class="row px-4 mt-9">
                <div class="assesment-btn-before mr-4" role="button">
                    <i class="kejar-arrow-left"></i>
                    <h5 class="pl-2">Sebelumnya</h5>
                </div>
                <div class="assesment-btn-next" role="button">
                    <h5 class="pr-2">Selanjutnya</h5>
                    <i class="kejar-arrow-right"></i>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


@push('script')

<script>

    function toggleDrawer() {
        var x = document.getElementById("drawer");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function myFunction() {
        var medScreen = window.matchMedia("(max-width: 1200px)")

        if (typeof window !== 'undefined') {
            if (medScreen.matches === true) { // If media query matches
                toggleDrawer();
            }
        }
    }
    // if (typeof window !== 'undefined') {
    // var y = window.matchMedia("(max-width: 1200px)")
    // y.addListener(myFunction) // Attach listener function on state changes
    // }

</script>
