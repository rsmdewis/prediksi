<!DOCTYPE html>
<html lang="en">

@include('layout.header')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layout.navbar')

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    
                    <h4 class="h3 mb-4 text-gray-800 font-weight-bold text-primary">{{ $post->title }}</h4>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Berita</h6>
                                </div> -->
                                <div class="card-body">
                                    <div class="list-group">
                                        <p>{{ $post->content }}</p>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                        <a href="{{ url()->previous() }}" class="btn btn-warning">Kembali</a>
                                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Bagian Kiri: Menampilkan Komentar -->
                        <div class="col-lg-6">
                            <div class="mt-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0">Komentar</h5>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($comments as $comment)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h6 class="card-title text-primary" style="font-size: 14px;">{{ $comment->email }}</h6>
                                                <p class="card-text" style="font-size: 14px;">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Kanan: Form Komentar -->
                        <div class="col-lg-6">
                            <div class="mt-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0">Kirim Komentar</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('posts.comments.store', $post->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Nama:</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" name="email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="content">Komentar:</label>
                                                <textarea name="content" class="form-control" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Kirim</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2024</span>
                    </div>
                </div>
            </footer> -->
            @include('layout.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>

</body>

</html>