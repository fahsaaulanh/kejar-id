
@extends('layout.index')
@section('title','Ulasan')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">

@section('container')
<div class="container">




                <!--Info box-->
        <div class="alert-info border border-5 mt-1 h-auto ">
            <div class="row">
                <div class="col-1 mt-2 ">
                    <i class="kejar-info text-purple m-4 font-24"></i>
                </div>
                <div class="col mt-1">
                    <div class="text-purple font-15 m-1 ">
                        Terbitkan aktivitas agar dapat dilihat oleh siswa
                    </div>
                </div>
            </div>
        </div>






                <!--Button Kembali dan publish-->
        <div class="mt-6">
            <div class="row">
                <div class="col">
                        <!-- buttonback-->
                    <a class="btn-back" href="">
                        <i class="kejar-back"></i>
                        Kembali
                    </a>
                </div>
                <div class="col">
                    <button class="btn btn-primary float-right w-autor " data-toggle="modal">
                        <a href="#publish" data-toggle="modal">
                            <div class="row">
                                <div class="col-1 mt-1">
                                    <i class="kejar-upload text-white font-15"></i>
                                </div>
                                <div class="col-1">
                                    <div class="text-white font-15">Terbitkan</div>
                                </div>
                            </div>
                        </a>
                    </button>
                </div>
            </div>
        </div>

   





                 <!-- Breadcumb-->
        <div class="mt-7">
            <nav class="breadcrumb" >
                <a class="breadcrumb-item" href="">Matematika</a>
                <a class="breadcrumb-item" href="">Persamaan garis lurus</a>
                <span class="breadcrumb-item active">
                    Konsep Persamaan garis lurus
                </span>
            </nav>
        </div>






                <!-- page title -->
        <div class="page-title" >
            <div class="row">
                <div class="col">
                    <h2 class="mb-08rem">
                        Ulasan: Persamaan Garis Lurus
                        <a href="#EditJudul" data-toggle="modal">
                            <i class="kejar-edit text-blue-2 font-24" ></i>
                        </a>
                    </h2>
                </div>
            </div>
        </div>






                <!--form durasi baca-->
        <form action="" method="GET">
            <div class="p-3 mb-2 bg-light text-dark h-auto" >
                Atur estimasi durasi baca
                <a class="asessment-timer float-right"  href="#EditDurasi" data-toggle="modal" >Atur</a>
                 <h3>- </h3>
            </div>
            <div class="mt-7">
                <div class="mb-3">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Buat ulasan materi..."data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></textarea>
                </div>
            </div>
        </form>
       





                <!-- Form Editor-->
        <div class="row" class="collapse" id="collapseExample">
            <div class="col">
                <div class="w-384r">
                    <div class="p-3 mb-2 bg-light text-dark" >
                        <div class="h-32r">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col">
                                        <a href="">
                                            <i class="kejar-bold font-24"></i>
                                        </a>
                                        <a href="">
                                            <i class="kejar-italic font-24"></i>
                                        </a>
                                        <a href="">
                                            <i class="kejar-underlined font-24"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="">
                                            <i class="kejar-heading font-24"></i>
                                        </a>
                                        <a href="">
                                            <i class="kejar-bullet font-24"></i>
                                        </a>
                                        <a href="">
                                            <i class="kejar-number font-24"></i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="">
                                            <i class="kejar-photo font-24"></i>
                                        </a>
                                        <a href="">
                                            <i class="kejar-link font-24"></i>
                                        </a>
                                    </div>    
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <button class="btn btn-revise float-right shadow-sm p-3 mb-5 bg-body rounded">Simpan</button>
            </div>
        </div>







                <!--Modal Edit judul-->
        <div class="modal fade" id="EditJudul" tabindex="-1" aria-labelledby="modelTitleId" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-weight-bold">Ubah Judul Ulasan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="kejar-close"></i></span>
                        </button>
                    </div>
                    <form action="#" method="GET">
                        <div class="modal-body">
                            <tr>
                                <td><input type="text" class="form-control" id="InputDurasiBaca" placeholder=""></td>
                            </tr>
                        </div>
                        <div class="modal-footer border-0 justify-content-end">
                            <div>
                                <button type="button" class="btn btn-transparent rounded-0" data-dismiss="modal">Batal</button>
                                <a href="" class="btn btn-primary">simpan</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


      




                <!--modal publish-->
        <div class="modal fade" id="publish" tabindex="-1" aria-labelledby="modelTitleId" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-weight-bold">Terbitksn Ulasan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="kejar-close"></i></span>
                        </button>
                    </div>
                    <form action="#" method="GET">
                        <div class="modal-body">
                            <p>Pastikan ulasan sudah sempurna. Lanjut terbitkan ulasan</p>
                        </div>
                        <div class="modal-footer border-0 justify-content-end">
                            <div>
                                <button type="button" class="btn btn-transparent rounded-0" data-dismiss="modal">Cek Kembali</button>
                                <button href="/teacher/activity-bank/ulasan" class="btn btn-primary">Terbitkann</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>






                <!--Modal Edit Durasi-->
        <div class="modal fade" id="EditDurasi" tabindex="-1" aria-labelledby="modelTitleId" style="display: none;" aria-hidden="true">
            <div class="modal-fix modal-dialog" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header border-0">
                        <h5 class="modal-title font-weight-bold">Atur Estimasi Durasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="kejar-close"></i></span>
                        </button>
                    </div>
                    <form action="#" method="GET">
                        <div class="modal-body">
                            <p>Berapa lama kira - kira waktu yang dibutuhkan siswa untuk membaca ulasan?</p>
                            <table>
                                <tr>
                                    <td>
                                        <div class="w-384r">
                                            <input type="text" class="form-control" id="InputDurasiBaca" placeholder=""></td>
                                        </div>
                                    <td>Menit</td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer border-0 justify-content-end">
                            <div>
                                <button type="button" class="btn btn-transparent rounded-0" data-dismiss="modal">Batal</button>
                                <a href="" class="btn btn-primary">simpan</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>




      
        


</div>          <!-- tutup class conatiner -->


 