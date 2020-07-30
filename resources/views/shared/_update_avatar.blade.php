<!-- Modal -->
<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ url( strtolower(session('user.role')) . '/change-profile') }}" method="post" enctype="multipart/form-data">
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
                                @if (session('user.role') === 'STUDENT' || 'TEACHER')
                                    @if (!is_null(session('user.userable.photo')))
                                    <img src="{{ session('user.userable.photo') }}" data-pict="notNull" class="profile-pict" alt="">
                                    @else
                                    <img src="{{ asset('assets/images/profile/default-picture.jpg') }}" data-pict="Null" class="profile-pict" alt="">
                                    @endif
                                @endif
                                <button type="button" class="edit-pict-btn">
                                    <i class="kejar-play"></i>
                                </button>
                            </div>
                            @if (session('user.role') === 'STUDENT')
                                @if (!is_null(session('user.userable.photo')))
                                <input type="hidden" name="photo" value="{{ session('user.userable.photo') }}">
                                @else
                                <input type="file" name="photo" hidden>
                                @endif
                            @endif
                            <input type="hidden" name="student" value="{{ session('user.id') }}">
                            <input type="hidden" name="photo" value="{{ session('user.userable.photo') }}">
                        </div>
                        <div class="col-12">
                            <h3>{{ session('user.userable.name') }}</h3>
                            <table class="profile-table">
                                @if (session('user.role') == 'STUDENT')
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
                                    <td>{{ session('user.userable.gender') }}</td>
                                </tr>
                                <tr>
                                    <td>Sekolah</td>
                                    <td>{{ session('user.userable.gender') }}</td>
                                </tr>
                                @elseif(session('user.role') == 'TEACHER')
                                <tr>
                                    <td>NIP</td>
                                    <td>{{ session('user.userable.nip') }}</td>
                                </tr>
                                <tr>
                                    <td>Sekolah</td>
                                    <td>{{ session('user.userable.gender') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <div>
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary save-btn-1">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
                            <img src="{{ session('user.userable.photo') }}" class="profile-pict-crop" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" class="btn btn-cancel cancel-edit">Batal</button>
                    <button type="button" class="btn btn-primary save-btn-2">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
