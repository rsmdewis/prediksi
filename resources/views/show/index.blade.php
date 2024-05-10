<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Prediksi Pertanian</title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                @include('layout.navbar')
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800 font-weight-bold text-primary">Prediksi Produksi Padi di Indonesia</h1>

                    <div id="postList" class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="list-group">
                                        <post-item v-for="post in posts" :key="post.id" :post="post"></post-item>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            @include('layout.footer')

        </div>

    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Vue.js script -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <!-- Axios for HTTP requests -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Vue component for post item -->
    <script type="text/x-template" id="post-item-template">
        <a :href="'/komentar/' + post.id" class="list-group-item list-group-item-action">@{{ post.title }}</a>
    </script>

    <!-- Vue component for post item -->
    

</body>

</html>
