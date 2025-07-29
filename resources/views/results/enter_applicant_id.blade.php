<!DOCTYPE html>
<html>
<head>
    <title>Enter Applicant ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h3 class="mb-4">View Your Evaluation Results</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="applicantForm" method="POST" action="{{ route('results.generate') }}">
            @csrf
            <div class="mb-3">
                <label for="applicantID" class="form-label">Applicant ID</label>
                <input type="text" class="form-control" id="applicantID" name="applicantID" value="{{ $preFillID ?? '' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">View Results</button>
        </form>
    </div>
</body>
</html>
