<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Profile Picture Upload</h1>
    
    <form id="uploadForm" enctype="multipart/form-data">
        @csrf
        <input type="file" name="profile_picture" id="fileInput" accept="image/*">
        <button type="button" onclick="testUpload()">Upload</button>
    </form>
    
    <div id="result"></div>
    
    <script>
        function testUpload() {
            const fileInput = document.getElementById('fileInput');
            const file = fileInput.files[0];
            
            if (!file) {
                alert('Please select a file');
                return;
            }
            
            const formData = new FormData();
            formData.append('profile_picture', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch('/student/upload-profile-picture', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerHTML = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                document.getElementById('result').innerHTML = 'Error: ' + error.message;
            });
        }
    </script>
</body>
</html>