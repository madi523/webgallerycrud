<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 50px;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .small-image {
                width: 400px;
            }
            .hover:hover {
                color: #0000FF;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class="container-fluid">
                    <div class="row justify-content-center mt-4">
                        <h2 class="card-header w-100 m-1 text-center">Main Page</h2>
                    </div>
                    <div class="row justify-content-left m-4">
                        <label class="mr-2">Sort by category</label>
                        <div class="dropdown">
                          <p class="btn dropdown-toggle" id="categoryDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Категории<i class="fa fa-sort"></i></p>
                          <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            <li class="dropdown-item" onclick="categorySort(0)">All</li>
                            @foreach ($categories as $category)
                            <li class="dropdown-item" onclick="categorySort('{{$category->id}}')">{{ $category->category}}</li>
                            @endforeach
                          </ul>
                        </div>
                        <label class="ml-4 hover" onclick="sortTable(0)">Sort by name &#8593 &#8595</label>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <table class="table table-hover" id="imgTable">
                                <thead>
                                    <tr>
                                        <th class="cs-p-1">Name</th>
                                        <th class="cs-p-1">Picture</th>
                                        <th class="cs-p-1">Description</th>
                                        <th class="cs-p-1">Categories</th>
                                        <th class="cs-p-1">Date added</th>
                                        <th class="cs-p-1"></th>
                                    </tr>
                                </thead>

                                @foreach ($images as $image)
                                    <tr>
                                        <td class="cs-p-1">{{ $image->title }}</td>
                                        <td class="cs-p-1"><img class="small-image" src="{{ asset('/storage/'.$image->url) }}"></td>
                                        <td class="cs-p-1">{{ $image->description }}</td>
                                        <td class="cs-p-1">{{ $image->categoryId }}</td>
                                        <td class="cs-p-1">{{ $image->created_at }}</td>
                                        <td hidden>{{ $image->id }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-md-2">
                            <div class="card-header">
                                <h3>Tags</h3>
                            </div>
                            <div class="card-body">
                              @foreach ($tags as $tag)
                                <a class="hover" onclick="tagSort('{{$tag->imageId}}')">{{ $tag->tag }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                  
            </div>
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, x1, y1, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("imgTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if(n == 0){ //if string
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    } else if(n == 4) { 
      //if number
      if (dir == "asc") {
        if (Number(x.innerHTML) > Number(y.innerHTML)) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (Number(x.innerHTML) < Number(y.innerHTML)) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    } 
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function categorySort(n) {
  // Declare variables
  var table, tr, td, j, txtValue;
  table = document.getElementById("imgTable");
  tr = table.getElementsByTagName("tr");
  // Loop through all table rows, and hide those who don't match the search query
  for (j = 0; j < tr.length; j++) {
    td = tr[j].getElementsByTagName("td")[3];
    if (td) {
      if (n == td.innerHTML) {
        tr[j].style.display = "";
      } else if (n == 0) {
        tr[j].style.display = "";
      } else {
        tr[j].style.display = "none";
      } 
    }
  }
}

function tagSort(n) {
  // Declare variables
  var table, tr, td, j, txtValue;
  table = document.getElementById("imgTable");
  tr = table.getElementsByTagName("tr");
  // Loop through all table rows, and hide those who don't match the search query
  for (j = 0; j < tr.length; j++) {
    td = tr[j].getElementsByTagName("td")[5];
    if (td) {
      if (n == td.innerHTML) {
        tr[j].style.display = "";
      } else if (n == 0) {
        tr[j].style.display = "";
      } else {
        tr[j].style.display = "none";
      } 
    }
  }
}

</script>
    </body>
</html>