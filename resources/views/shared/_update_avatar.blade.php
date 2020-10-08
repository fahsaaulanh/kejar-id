<!-- Modal -->
<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ url( strtolower(session('user.role')) . '/change-profile') }}" method="post" name="change_profile">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Foto Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="kejar-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="avatar-group">
                                @if (session('user.role') === 'STUDENT')
                                    @if (!is_null(session('user.userable.photo')))
                                        <img src="{{ session('user.userable.photo') }}" class="profile-pict" alt="">
                                    @else
                                        <img src="{{ asset('assets/images/general/photo-profile-default.svg') }}" class="profile-pict" alt="">
                                    @endif
                                @endif
                                <button type="button" class="edit-pict-btn">
                                    <i class="kejar-edit"></i>
                                </button>
                            </div>
                            @if (session('user.role') !== 'ADMIN')
                                <input type="file" name="select_photo" hidden>
                                <input type="hidden" name="photo">
                            @endif
                        </div>
                        <div class="col-12">
                            <h3>{{ session('user.userable.name') }}</h3>
                            <table class="profile-table">
                                @if (session('user.role') === 'STUDENT')
                                <tr>
                                    <td>NIS</td>
                                    <td>{{ session('user.userable.nis') }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>{{ session('user.userable.nisn') }}</td>
                                </tr>
                                <tr>
                                    <td>Rombel</td>
                                    <td>{{ session('user.userable.class_name') }}</td>
                                </tr>
                                <tr>
                                    <td>Sekolah</td>
                                    <td>{{ session('user.userable.school_name') }}</td>
                                </tr>
                                @elseif(session('user.role') === 'TEACHER')
                                <tr>
                                    <td>NIP</td>
                                    <td>{{ session('user.userable.nip') }}</td>
                                </tr>
                                <tr>
                                    <td>Sekolah</td>
                                    <td>{{ session('user.userable.school_name') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atur Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="crop-area">
                            @if (session('user.role') === 'STUDENT')
                                @if (!is_null(session('user.userable.photo')))
                                <img src="" class="profile-pict-crop" alt="">
                                @else
                                <img src="{{ asset('assets/images/general/photo-profile-default.svg') }}" id="profile-pict-crop" class="profile-pict-crop" alt="">
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel">Batal</button>
                    <button type="button" class="btn btn-primary" id="save-btn">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
