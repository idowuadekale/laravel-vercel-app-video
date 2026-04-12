 <div class="container">
     <nav class="blog-pagination justify-content-center d-flex">
         <ul class="pagination">
             <li class="page-item">
                 <a href="#" id="backButton" class="page-link" title="Click to go back" aria-label="Previous">
                     <i class="fa-solid fa-angle-left"></i>
                 </a>
             </li>
             <li class="page-item">
                 <a href="{{ route('welcome') }}" class="page-link">Home</a>
             </li>
             <li class="page-item">
                 @if (request()->routeIs('aboutus'))
                     <a href="{{ route('galleries.index') }}" class="page-link">Gallery</a>
                 @elseif (request()->routeIs('galleries'))
                     <a href="{{ route('programs') }}" class="page-link">Programs</a>
                 @elseif (request()->routeIs('subscribe'))
                     <a href="{{ route('login') }}" class="page-link">Admin</a>
                 @else
                     <a href="{{ route('aboutus') }}" class="page-link">About</a>
                 @endif
             </li>
             <li class="page-item">
                 <a href="#" id="forwardButton" class="page-link" title="Click to go forward" aria-label="Next">
                     <i class="fa-solid fa-angle-right"></i>
                 </a>
             </li>
         </ul>
     </nav>
 </div>
