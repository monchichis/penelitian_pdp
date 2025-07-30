<!-- Content Wrapper. Contains page content -->
<style>
    /* Reset default margin and padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f3f4f6;
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
    }

    .error-container {
        text-align: center;
    }

    .error-code {
        font-size: 150px;
        font-weight: bold;
        color:rgb(77, 86, 255);
        line-height: 1;
        animation: bounce 2s infinite;
    }

    .error-message {
        font-size: 24px;
        margin-top: 20px;
        color: #555;
    }

    .error-description {
        font-size: 16px;
        margin-top: 10px;
        color: #777;
    }

    .back-home {
        display: inline-block;
        margin-top: 30px;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #007bff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .back-home:hover {
        background-color: #0056b3;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    /* Responsive Design */
    @media (max-width: 600px) {
        .error-code {
            font-size: 100px;
        }

        .error-message {
            font-size: 20px;
        }

        .error-description {
            font-size: 14px;
        }
    }
</style>
<div class="content-wrapper">

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo $title; ?></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a><?php echo $title; ?></a>
                </li>
            </ol>
        </div>
    </div>
    <br/>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Default box -->
            <div class="row">
                <div class="col-md-12">
                    <div class="error-container">
                        <div class="error-code">404</div>
                        <div class="error-message">Oops! Penilaian Tahun Ini Sudah Dilakukan</div>
                        <div class="error-description">
                            Maaf, dicoba lagi tahun depan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>    