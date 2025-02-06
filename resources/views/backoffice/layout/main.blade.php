<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LPSK Backoffice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- icon web --}}
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="{{ asset('backoffice/assets/adminlte/plugins/fontawesome-free/css/all.min.css') }}"> --}}
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('backoffice/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backoffice/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('backoffice/assets/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backoffice/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('backoffice/assets/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backoffice/assets/adminlte/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  {{-- summernote --}}
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">

  {{-- slick --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>

  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  
    @include('backoffice.layout.navbar')

    @include('backoffice.layout.sidebar')

    <div class="content-wrapper">

      {{-- @if (Auth::user()->role_id == 4)
      <div class="card card-outline card-primary mt-2">
        <div class="card-header">
            <div class="row">
                <div class="col-md-2 fakultas ">
                    <h5>
                        Fakultas: <b>{{ auth()->user()->fakultas->fakultas }}</b>
                    </h5>
                </div>
                <div class="col-md-2 jurusan ">
                    <h5>
                        Jurusan: <b>{{ auth()->user()->jurusan->jurusan }}</b>
                    </h5>
                </div>
                <div class="col-md-2 prodi ">
                    <h5>
                        Program Studi: <b>{{ auth()->user()->programStudi->program_studi }}</b>
                    </h5>
                </div>
                <div class="col-md-4 tahunAkademik ">
                    <h5>
                        Tahun Akademik: <b>{{ auth()->user()->tahunAkademik->tahun_akademik }} / {{ auth()->user()->tahunAkademik->semester }}</b>
                    </h5>
                </div>
                <div class="col-md-2 semester">
                    <h5>
                        Semester: <b>{{ auth()->user()->semester }}</b>
                    </h5>
                </div>
            </div>
        </div>
      </div>
      @endif --}}

      {{-- @if (Auth::user()->jenis_kelamin == null || Auth::user()->agama == null 
          || Auth::user()->alamat == null || Auth::user()->no_hp == null 
          || Auth::user()->foto_profil == null)
          @include('backoffice.layout.cek-profil')
      @endif --}}

      @yield('content')

    </div>

    @include('backoffice.layout.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-light">
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('backoffice/assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('backoffice/assets/adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backoffice/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backoffice/assets/adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('backoffice/assets/adminlte/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('backoffice/assets/adminlte/dist/js/demo.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('backoffice/assets/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backoffice/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backoffice/assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backoffice/assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('backoffice/assets/adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('backoffice/assets/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

{{-- Slick --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js" integrity="sha512-eP8DK17a+MOcKHXC5Yrqzd8WI5WKh6F1TIk5QZ/8Lbv+8ssblcz7oGC8ZmQ/ZSAPa7ZmsCU4e/hcovqR8jfJqA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- include summernote css/js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

<script>
  $('#description').summernote({
    placeholder: 'Description',
    tabsize: 2,
    height: 400
  });
</script>

<!-- page script -->
<script>
  $(function () {

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })

    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script type="text/javascript">
  $(function () {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      $('.swalDefaultSuccess').click(function () {
        Toast.fire({
          icon: 'success',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
    });
</script>

{{-- review foto profil --}}
<script>
  function previewFotoProfil() {
      const fotoProfil = document.querySelector('#foto_profil')
      const fotoPreviewProfil = document.querySelector('.foto_profil')

      fotoPreviewProfil.style.display = 'block'
      fotoPreviewProfil.style.width = '150px'
      fotoPreviewProfil.style.height = '150px'

      const oFReader = new FileReader()
      oFReader.readAsDataURL(fotoProfil.files[0])

      oFReader.onload = function(oFREvent) {
        fotoPreviewProfil.src = oFREvent.target.result
      }
  }
</script>


{{-- review foto --}}
<script>
  function preview() {
      const foto = document.querySelector('#foto')
      const fotoPreview = document.querySelector('.foto')

      fotoPreview.style.display = 'block'
      fotoPreview.style.width = '200px'
      fotoPreview.style.height = '150px'

      const oFReader = new FileReader()
      oFReader.readAsDataURL(foto.files[0])

      oFReader.onload = function(oFREvent) {
          fotoPreview.src = oFREvent.target.result
      }
  }
</script>

{{-- review cover --}}
<script>
  function previewCover() {
      const cover = document.querySelector('#reviewCover')
      const coverPreview = document.querySelector('.reviewCover')

      coverPreview.style.display = 'block'
      coverPreview.style.width = '200px'
      coverPreview.style.height = '150px'

      const oFReader = new FileReader()
      oFReader.readAsDataURL(cover.files[0])

      oFReader.onload = function(oFREvent) {
          coverPreview.src = oFREvent.target.result
      }
  }
</script>

</body>
</html>
