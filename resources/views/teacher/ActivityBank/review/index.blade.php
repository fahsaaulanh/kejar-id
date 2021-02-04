
@extends('layout.index')
@section('title','Ulasan')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">

@section('container')
<div class="container">

                <!--Info box-->
        <div class="alert-info" >
            <div class="border border-secondary">
                <table width="100%" height="100%" >
                    <tr>
                        <td style="float:center;">
                            <div class="row">
                                <div class="col-5">
                                    <div class="col-3">
                                        <i class="kejar-info" style="size:20px;"></i>
                                    </div>
                                </div>
                            </div> 
                        </td>
                        <td>
                            <div class="text-purple">
                            Terbitkan aktivitas agar dapat dilihat oleh siswa
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
   




        
                <!--Button Kembali dan publish-->
       <div class="mt-7">
            <table width="100%">
                <tr>
                    <td>
                        <!-- buttonback-->
                        <a class="btn-back" href="">
                            <i class="kejar-back"></i>
                            Kembali
                        </a>
                    </td>
                    <td style="float:right;" >
                        <!--button Publish-->
                        <a href="#publish" data-toggle="modal">
                            <button type="button" class="btn btn-primary" >
                                <table>
                                    <tr>
                                        <td> <i class="kejar-upload" style="color:white;"></i></td>
                                        <td>
                                            <div class="text-white">Terbitkan</div>
                                        </td>
                                    </tr>
                                </table>  
                            </button>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
   





                 <!-- Breadcumb-->
        <div class="mt-7">
            <table style="margin-top:30px;">
                <nav class="breadcrumb" >
                    <a class="breadcrumb-item" href="">Matematika</a>
                    <a class="breadcrumb-item" href="">Persamaan garis lurus</a>
                    <span class="breadcrumb-item active">
                        Konsep Persamaan garis lurus
                    </span>
                </nav>
            </table>
        </div>




                <!-- page title -->
        <div class="page-title" >
            <table>
                <tr>
                    <td>
                        <h2 class="mb-08rem">Ulasan: Persamaan Garis Lurus</h2>
                    </td>
                    <td>
                        <div class="wh-16r">
                            <a href="#EditJudul" data-toggle="modal">
                                <div class="text-blue">
                                    <i class="kejar-edit"></i>
                                </div>
                            </a>
                        </div>
                    </td>
                </tr>
            </table>
        </div>






                <!--form durasi baca-->
        <form action="GET">
            <div class="p-3 mb-2 bg-light text-dark" style="height:auto; ">
                <table  width="100%" >
                    <tr>
                        <td>
                            Atur estimasi durasi baca
                        </td>
                        <td>
                            <a class="asessment-timer"  href="#EditDurasi" data-toggle="modal" style="float:right;">Atur</a>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <div class="texte2">
                            <h3>- </h3>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mt-7">
                <div class="mb-3">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Buat ulasan materi..."></textarea>
                </div>
            </div>
        </form>
       





                <!-- Form Editor-->
        <div class="w-384r">
            <div class="p-3 mb-2 bg-light text-dark" >
                <div class="h-32r">
                    <div class="w-100">
                        <table>
                            <tr>
                                <td>
                                    <a href="">
                                        <i class="kejar-bold"></i>
                                    </a>
                                    <a href="">
                                        <i class="kejar-italic"></i>
                                    </a>
                                    <a href="">
                                        <i class="kejar-underlined"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="">
                                        <i class="kejar-heading"></i>
                                    </a>
                                    <a href="">
                                        <i class="kejar-bullet"></i>
                                    </a>
                                    <a href="">
                                        <i class="kejar-number"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="">
                                        <i class="kejar-photo"></i>
                                    </a>
                                    <a href="">
                                        <i class="kejar-link"></i>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
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
                                <a href="" class="btn btn-primary">Terbitkann</a>
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
                            <tr>
                                <td width="300px"><input type="text" class="form-control" id="InputDurasiBaca" placeholder=""></td>
                                <td>Menit</td>
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




        




      
        


</div>          <!-- tutup class conatiner -->
