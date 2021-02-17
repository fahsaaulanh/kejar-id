
@extends('layout.index')
@section('title','Ulasan')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">

@section('container')
<div class="container">

              

                
                
                <!-- Button Back dan Revisi -->
        <div class="row">
            <div class="col">
                    <!-- buttonback-->
                <a class="btn-back" href="">
                    <i class="kejar-back"></i>
                    Kembali
                </a>
            </div>
            <div class="col">
                <button class="btn btn-revise float-right shadow-sm p-3 mb-5 bg-body rounded" href="#publish" data-toggle="modal" data-toggle="modal">
                    <i class="kejar-edit text-blue-2"></i>
                    Revisi
                </button>
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
            <h2 class="mb-08rem">Ulasan: Persamaan Garis Lurus</h2>
        </div>





        <div class="content">
            <h3>Lorem</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic nam eaque accusantium quidem est incidunt, asperiores delectus distinctio dolorem similique blanditiis voluptate dicta et id rerum ea molestias consectetur iusto. Voluptatum placeat nihil libero, earum consectetur sequi eius aliquam. Repellendus quasi cum vero dolor maiores quam tenetur delectus, animi beatae. Expedita vero numquam rerum tempore aperiam perferendis labore porro facilis ipsa in quas odio aspernatur laudantium, dolor, beatae sit modi eius nihil voluptate, vitae fuga. Delectus provident quas ea odio neque! Totam explicabo alias laudantium iure eaque ex? Maxime maiores deleniti nulla. Voluptatum perferendis maxime cumque dicta autem reiciendis fugiat?
            </p>
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


 