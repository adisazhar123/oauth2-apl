<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oauth Clients</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .card {
            transition: box-shadow 0.3s;
        }
        .card:hover {
            box-shadow: 0 0 11px rgba(33,33,33,.2); 
        }

        .card-body {
            text-align: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <form method="post">
                    <label>Do You Authorize TestClient?</label><br />
                    <p>TestClient will receive <strong>all</strong> your TCBook friends.</p>
                    <img class="mb-3" src="http://reels.syntheticpictures.com/img/directors/blank-avatar.png" alt="" width="128">
                    <input type="submit" name="authorized" value="yes" class="btn btn-success mb-1" style="width: 100%">
                    <input type="submit" name="authorized" value="no" class="btn btn-danger" style="width: 100%">
                </form>
            </div>
        </div>
    </div>    
</div>




    
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>