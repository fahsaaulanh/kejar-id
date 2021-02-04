@extends('layout.index')

@section('title', 'Daftar Pelajaran')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">


<div class="container">

    <!-- Link Back -->
    <a class="btn-back" href="{{ url('/teacher/games') }}">
        <i class="kejar-back"></i>Kembali
    </a>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('/teacher/pelajaran') }}">Pelajaran</a>
        <span class="breadcrumb-item active">Matematika</span>
    </nav>

     <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">Pilih Pelajaran</h2>
    </div>
    
    <!--Tambah Pelajaran -->
    <button class="btn-upload font-15" data-toggle="modal" data-target="#create-tambah-pelajaran">
            <i class="kejar-add"></i>Tambah pelajaran
    </button>

    <!--Modal Tambah Pelajaran -->
    <div class="table-questions border-top-none">
        <div class="modal fade" id="create-tambah-pelajaran">
            <div class="modal-dialog  modal-fix" role="document">
                <input type="hidden" name="question_type" value="MCQSA">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Pelajaran<br>
                                <small>1/2 Atur Pelajaran</small>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="kejar kejar-close"></i>
                            </button>
                        </div>

                        <!-- Dropdown pilih mapel -->
                        
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Mata Pelajaran</label>
                                        <div class="form-group">
                                            <select class="form-control" id="FormControlSelectMapel" style=" height: 5rem;">
                                                <option>Pilih mapel</option>
                                                <option>Matematika</option>
                                                <option>Bahasa Indonesia</option>
                                                <option>Bahasa Inggris</option>
                                            </select>
                                     </div>
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Kelas/Tingkat</label>
                                        <div class="form-group">
                                            <select class="form-control" id="FormControlSelecttingkat" style=" height: 5rem; ">
                                                <option> Pilih tingkat </option>
                                                <option>Kelas 10</option>
                                                <option>Kelas 11</option>
                                                <option>Kelas 12</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Keterangan</label>
                                    <input type="text" class="form-control" id="message-text" placeholder="Tambah keterangan apabila perlu">
                                </div>
                            </form>
                        </div>
                    
                        <!-- Button Batal dan lanjut -->
                        
                        <div class="modal-footer border-0 p-0">
                            <div class="d-flex justify-content-end w-100">
                                <button type="button" class="btn btn-white text-primary btn-cancel mr-4" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal-share">Lanjut</button>
                            </div>
                        </div> 
                    </div>
            </div>
        </div>
    </div>

    <!--Modal lanjut tambah pelajaran -->

    <div class="modal fade" id="Modal-share" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-fix" role="document">
            <input type="hidden" name="question_type" value="MCQSA">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pelajaran<br>
                            <small>2/2 Atur Pelajaran</small>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="kejar kejar-close"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="alert-info" >
                            <div class="border border-secondary">
                                <table width="100%" height="100%" style="color=#582CA0" >
                                    <tr>
                                        <td style="float:center;">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="col-3">
                                                        <i class="kejar-info" style="size:25px;"></i>
                                                    </div>
                                                </div>
                                            </div> 
                                        </td>
                                        <td style="color:#582CA0">Klik nama rombel untuk memilih siswa satu persatu</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="check-group row pt-2">
                                    <input type="checkbox" id="schedule-check-all" onchange="scheduleCheckAll()" class="col-1 mt-1 ml-3">
                                        <label for="schedule-check-all" class="col pl-1 mt-2">
                                            <b>Pilih semua rombel</b>
                                        </label>
                                </div>
                            </div>
                        </div>

                        <!-- checkbox dan dropdown -->

                        <div id="studentGroupCheck">
                            <div class="accordion mt-3" id="accordion-1">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0" onclick="getStudents('1')">
                                            <div class="row">
                                                <div class="col-1 ml-1">
                                                    <input type="checkbox" data-toggle="collapse" aria-expanded="true" aria-controls="collapseStudents-1" id="schedule-check-all-1" onclick="selectAllStudents('1')" class="unCheckedData" value="1">
                                                </div>
                                                <div class="col pl-0" data-toggle="collapse" data-target="#collapseStudents-1" aria-expanded="true" aria-controls="collapseStudents-1" style="cursor : pointer;">
                                                    <span data-toggle="collapse" data-target="#collapseStudents-1" aria-expanded="true" aria-controls="collapseStudents-1"> X RPL 1</span>
                                                    <span class="float-right">
                                                        <span class="count-students-group count-students-group-1">0</span>
                                                        siswa
                                                    </span>
                                                </div>
                                                <div class="col-1" data-toggle="collapse" data-target="#collapseStudents-1" aria-expanded="true" aria-controls="collapseStudents-1">
                                                    <i class="kejar-dropdown"></i>
                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                    <table id="collapseStudents-1" class="table table-bordered table-sm m-0 collapse" aria-labelledby="headingOne" data-parent="#accordion-1" style>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Siti Iswanti" value="r1s1" onclick="countStudents('1')" class="ml-1 unCheckedData students_group-1">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Siti Iswanti">Siti Iswanti</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Siti Iswanti">11907539</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Siti Iswanti" value="r1s2" onclick="countStudents('1')" class="ml-1 unCheckedData students_group-1">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Siti Iswanti">Siti Iswanti</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Siti Iswanti">11907539</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Siti Iswanti" value="r1s3" onclick="countStudents('1')" class="ml-1 unCheckedData students_group-1">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Siti Iswanti">Siti Iswanti</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Siti Iswanti">11907539</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Siti Iswanti" value="r1s4" onclick="countStudents('1')" class="ml-1 unCheckedData students_group-1">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Siti Iswanti">Siti Iswanti</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Siti Iswanti">11907539</label>
                                            </td>
                                        </tr>
                                    </table>   
                                </div>
                            </div>
                        </div>

                        <div id="studentGroupCheck">
                            <div class="accordion mt-3" id="accordion-2">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0" onclick="getStudents('2')">
                                            <div class="row">
                                                <div class="col-1 ml-1">
                                                    <input type="checkbox" data-toggle="collapse" aria-expanded="true" aria-controls="collapseStudents-2" id="schedule-check-all-2" onclick="selectAllStudents('2')" class="unCheckedData" value="2">
                                                </div>
                                                <div class="col pl-0" data-toggle="collapse" data-target="#collapseStudents-2" aria-expanded="true" aria-controls="collapseStudents-2" style="cursor : pointer;">
                                                    <span data-toggle="collapse" data-target="#collapseStudents-2" aria-expanded="true" aria-controls="collapseStudents-2"> X RPL 1</span>
                                                    <span class="float-right">
                                                    <span class="count-students-group count-students-group-2">0</span>
                                                        siswa
                                                    </span>
                                                </div>
                                                <div class="col-1" data-toggle="collapse" data-target="#collapseStudents-2" aria-expanded="true" aria-controls="collapseStudents-2">
                                                    <i class="kejar-dropdown"></i>
                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                    <table id="collapseStudents-2" class="table table-bordered table-sm m-0 collapse" aria-labelledby="headingOne" data-parent="#accordion-2" style>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Zahrani-Putri-Solehah" value="r1s1" onclick="countStudents('2')" class="ml-1 unCheckedData students_group-2">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Zahrani-Putri-Solehah">Zahrani Putri Solehah</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Zahrani-Putri-Solehah">11907539</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Zahrani-Putri-Solehah" value="r1s2" onclick="countStudents('2')" class="ml-1 unCheckedData students_group-2">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Zahrani-Putri-Solehah">Zahrani Putri Solehah</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Zahrani-Putri-Solehah">11907539</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Zahrani-Putri-Solehah" value="r1s3" onclick="countStudents('2')" class="ml-1 unCheckedData students_group-2">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Zahrani-Putri-Solehah">Zahrani Putri Solehah</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Zahrani-Putri-Solehah">11907539</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Zahrani-Putri-Solehah" value="r1s4" onclick="countStudents('2')" class="ml-1 unCheckedData students_group-2">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Zahrani-Putri-Solehah">Zahrani Putri Solehah</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Zahrani-Putri-Solehah">11907539</label>
                                            </td>
                                        </tr>
                                    </table>   
                                </div>
                            </div>
                        </div>

                        <div id="studentGroupCheck">
                            <div class="accordion mt-3" id="accordion-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0" onclick="getStudents('3')">
                                            <div class="row">
                                                <div class="col-1 ml-1">
                                                    <input type="checkbox" data-toggle="collapse" aria-expanded="true" aria-controls="collapseStudents-3" id="schedule-check-all-3" onclick="selectAllStudents('3')" class="unCheckedData" value="3">
                                                </div>
                                                    <div class="col pl-0" data-toggle="collapse" data-target="#collapseStudents-3" aria-expanded="true" aria-controls="collapseStudents-3" style="cursor: pointer;">
                                                        <span data-toggle="collapse" data-target="#collapseStudents-3" aria-expanded="true" aria-controls="collapseStudents-3">X RPL 1</span>
                                                        <span class="float-right">
                                                            <span class="count-students-group count-students-group-3">0</span>
                                                            siswa
                                                        </span>
                                                    </div>
                                                    <div class="col-1" data-toggle="collapse" data-target="#collapseStudents-3" aria-expanded="true" aria-controls="collapseStudents-3">
                                                        <i class="kejar-dropdown"></i>
                                                    </div>
                                            </div>
                                        </h5>
                                    </div>
                                    <table id="collapseStudents-3" class="table table-bordered table-sm m-0 collapse" aria-labelledby="headingOne" data-parent="#accordion-3" style>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Ahmad Ikhsan Maulana" value="r1s1" onclick="countStudents('3')" class="ml-1 unCheckedData students_group-3">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Ahmad Ikhsan Maulana">Ahmad Ikhsan Maulana</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Ahmad Ikhsan Maulana">11906994</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Afa Fathin Al-aziz" value="r1s2" onclick="countStudents('3')" class="ml-1 unCheckedData students_group-3">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Afa Fathin Al-aziz">Afa Fathin Al-aziz</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Afa Fathin Al-aziz">11908021</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-Fadlan dyanuar" value="r1s3" onclick="countStudents('3')" class="ml-1 unCheckedData students_group-3">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Fadlan dyanuar">Fadlan dyanuar</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Fadlan dyanuar">11907221</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Azriel Fauzi Hermansyah" value="r1s4" onclick="countStudents('3')" class="ml-1 unCheckedData students_group-3">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Azriel Fauzi Hermansyah">Azriel Fauzi Hermansyah</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Azriel Fauzi Hermansyah">11907072</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div id="studentGroupCheck">
                            <div class="accordion mt-3" id="accordion-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0" onclick="getStudents('4')">
                                            <div class="row">
                                                <div class="col-1 ml-1">
                                                    <input type="checkbox" data-toggle="collapse" aria-expanded="true" aria-controls="collapseStudents-4" id="schedule-check-all-4" onclick="selectAllStudents('4')" class="unCheckedData" value="4">
                                                </div>
                                                <div class="col pl-0" data-toggle="collapse" data-target="#collapseStudents-4" aria-expanded="true" aria-controls="collapseStudents-4" style="cursor: pointer;">
                                                    <span data-toggle="collapse" data-target="#collapseStudents-4" aria-expanded="true" aria-controls="collapseStudents-4">X RPL 1</span>
                                                    <span class="float-right">
                                                        <span class="count-students-group count-students-group-4">0</span>
                                                        siswa
                                                    </span>
                                                </div>
                                                <div class="col-1" data-toggle="collapse" data-target="#collapseStudents-4" aria-expanded="true" aria-controls="collapseStudents-4">
                                                    <i class="kejar-dropdown"></i>
                                                </div>
                                            </div>
                                        </h5>
                                    </div>
                                    <table id="collapseStudents-4" class="table table-bordered table-sm m-0 collapse" aria-labelledby="headingOne" data-parent="#accordion-4" style>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Ahmad Ikhsan Maulana" value="r1s1" onclick="countStudents('4')" class="ml-1 unCheckedData students_group-4">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Ahmad Ikhsan Maulana">Ahmad Ikhsan Maulana</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Ahmad Ikhsan Maulana">11906994</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Afa Fathin Al-aziz" value="r1s2" onclick="countStudents('4')" class="ml-1 unCheckedData students_group-4">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Afa Fathin Al-aziz">Afa Fathin Al-aziz</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Afa Fathin Al-aziz">11908021</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-Fadlan dyanuar" value="r1s3" onclick="countStudents('4')" class="ml-1 unCheckedData students_group-4">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Fadlan dyanuar">Fadlan dyanuar</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Fadlan dyanuar">11907221</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="40px" class="text-center">
                                                <input name="student_data[]" type="checkbox" id="schedule-student-check-Azriel Fauzi Hermansyah" value="r1s4" onclick="countStudents('4')" class="ml-1 unCheckedData students_group-4">
                                            </td>
                                            <td width="50%">
                                                <label for="schedule-student-check-Azriel Fauzi Hermansyah">Azriel Fauzi Hermansyah</label>
                                            </td>
                                            <td>
                                                <label for="schedule-student-check-Azriel Fauzi Hermansyah">11907072</label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>

    <!--Matematika kelas-->

    <div id="assessment-teacher" class="content-body">
        <div class="list-group" data-url="#" data-token="lLj4v7yfwimuQcqDUjwRMjTVpLYCoSBfngFaQudw">
            <div class="list-group-item" data-toggle="collapse" data-target="#collapse-421dacb4-a3c1-46db-962e-653189a153f9" aria-expanded="false" aria-controls="collapse-421dacb4-a3c1-46db-962e-653189a153f9">
                <a href="javascript:void(0)" class="col-12">
                    <i class="kejar-pelajaran mr-4">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.125C0 0.779822 0.279822 0.5 0.625 0.5H6.87239C8.17752 0.5 9.32703 1.16676 9.9987 2.17834C10.6703 1.16681 11.8198 0.5 13.125 0.5H19.375C19.7202 0.5 20 0.779822 20 1.125V13.6771C20 13.8436 19.9336 14.0032 19.8154 14.1205C19.6973 14.2379 19.5373 14.3032 19.3708 14.3021L12.9692 14.2588C12.3003 14.2543 11.6575 14.518 11.1846 14.991L10.4419 15.7336C10.1979 15.9777 9.80214 15.9777 9.55806 15.7336L8.80668 14.9822C8.33784 14.5134 7.70196 14.25 7.03892 14.25H0.625C0.279822 14.25 0 13.9702 0 13.625V1.125ZM9.37239 4.24792C9.37124 2.86802 8.25229 1.75 6.87239 1.75H1.25V13H7.03892C7.89164 13 8.71442 13.2904 9.375 13.8165L9.37239 4.24792ZM10.625 13.8183V4.25C10.625 2.86929 11.7443 1.75 13.125 1.75H18.75V13.0479L12.9777 13.0088C12.12 13.003 11.2908 13.2913 10.625 13.8183Z" fill="#4C516D"/>
                        </svg> 
                    </i>
                    <span id="pts-1" >Matematika Kelas 10</span>
                </a>
            </div>

            <div class="list-group-item" data-toggle="collapse" data-target="#collapse-421dacb4-a3c1-46db-962e-653189a153f9" aria-expanded="false" aria-controls="collapse-421dacb4-a3c1-46db-962e-653189a153f9">
                <a href="javascript:void(0)" class="col-12">
                    <i class="kejar-pelajaran mr-4">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.125C0 0.779822 0.279822 0.5 0.625 0.5H6.87239C8.17752 0.5 9.32703 1.16676 9.9987 2.17834C10.6703 1.16681 11.8198 0.5 13.125 0.5H19.375C19.7202 0.5 20 0.779822 20 1.125V13.6771C20 13.8436 19.9336 14.0032 19.8154 14.1205C19.6973 14.2379 19.5373 14.3032 19.3708 14.3021L12.9692 14.2588C12.3003 14.2543 11.6575 14.518 11.1846 14.991L10.4419 15.7336C10.1979 15.9777 9.80214 15.9777 9.55806 15.7336L8.80668 14.9822C8.33784 14.5134 7.70196 14.25 7.03892 14.25H0.625C0.279822 14.25 0 13.9702 0 13.625V1.125ZM9.37239 4.24792C9.37124 2.86802 8.25229 1.75 6.87239 1.75H1.25V13H7.03892C7.89164 13 8.71442 13.2904 9.375 13.8165L9.37239 4.24792ZM10.625 13.8183V4.25C10.625 2.86929 11.7443 1.75 13.125 1.75H18.75V13.0479L12.9777 13.0088C12.12 13.003 11.2908 13.2913 10.625 13.8183Z" fill="#4C516D"/>
                        </svg> 
                    </i>
                    <span id="pts-1" >Matematika Kelas 11</span>
                </a>
            </div>

            <div class="list-group-item" data-toggle="collapse" data-target="#collapse-421dacb4-a3c1-46db-962e-653189a153f9" aria-expanded="false" aria-controls="collapse-421dacb4-a3c1-46db-962e-653189a153f9">
                <a href="javascript:void(0)" class="col-12">
                    <i class="kejar-pelajaran mr-4">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.125C0 0.779822 0.279822 0.5 0.625 0.5H6.87239C8.17752 0.5 9.32703 1.16676 9.9987 2.17834C10.6703 1.16681 11.8198 0.5 13.125 0.5H19.375C19.7202 0.5 20 0.779822 20 1.125V13.6771C20 13.8436 19.9336 14.0032 19.8154 14.1205C19.6973 14.2379 19.5373 14.3032 19.3708 14.3021L12.9692 14.2588C12.3003 14.2543 11.6575 14.518 11.1846 14.991L10.4419 15.7336C10.1979 15.9777 9.80214 15.9777 9.55806 15.7336L8.80668 14.9822C8.33784 14.5134 7.70196 14.25 7.03892 14.25H0.625C0.279822 14.25 0 13.9702 0 13.625V1.125ZM9.37239 4.24792C9.37124 2.86802 8.25229 1.75 6.87239 1.75H1.25V13H7.03892C7.89164 13 8.71442 13.2904 9.375 13.8165L9.37239 4.24792ZM10.625 13.8183V4.25C10.625 2.86929 11.7443 1.75 13.125 1.75H18.75V13.0479L12.9777 13.0088C12.12 13.003 11.2908 13.2913 10.625 13.8183Z" fill="#4C516D"/>
                        </svg> 
                    </i>
                    <span id="pts-1" >Matematika Kelas 12</span>
                </a>
            </div>
        </div>    
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>