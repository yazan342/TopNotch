<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Dashboard</title>
    <!-- Include any necessary CSS and JavaScript files -->
    <style>
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-md-6 {
            padding-right: 15px;
            padding-left: 15px;
        }

        p {
            font-size: 1rem;
        }

        strong {
            font-weight: bold;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }
    </style>

    <style>
        .card-title {
            color: #333;
            font-size: 2rem;
            font-weight: bold;
        }

        .card-text.display-3 {
            font-size: 4rem;
            font-weight: bold;
            color: #17a2b8;
            margin-bottom: 0;
        }

        .table thead th {
            font-weight: bold;
            color: #fff;
            font-size: 1rem;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.8rem;
            border-radius: 4px;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover,
        .btn-success:hover,
        .btn-danger:hover {
            opacity: 0.85;
        }

        .small {
            font-size: 0.8rem;
        }

        .table-responsive {
            max-height: 350px;
            overflow-y: auto;
        }

        .btn-primary.btn-sm {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
        }
    </style>

    <style>
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .card-text {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .img-fluid {
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
    <!-- For example, you can include Bootstrap CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">TOPNOTCH Dashboard</a>
    </nav>

    <!-- Main content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Include any necessary JavaScript files -->
    <!-- For example, you can include Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>
