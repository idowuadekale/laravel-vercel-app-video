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
                 <a href="{{ route('dashboard') }}" class="page-link">Admin</a>
             </li>
             <li class="page-item">
                 <a href="#" id="forwardButton" class="page-link" title="Click to go forward" aria-label="Next">
                     <i class="fa-solid fa-angle-right"></i>
                 </a>
             </li>
         </ul>
     </nav>
 </div>
