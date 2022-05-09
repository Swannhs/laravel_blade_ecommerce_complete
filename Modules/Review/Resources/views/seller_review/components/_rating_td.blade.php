<div class="review_star_icon text-nowrap">
    <i class="fas fa-star review_star {{$review->rating >= 1?'':'non_rated'}}"></i>
    <i class="fas fa-star review_star {{$review->rating >= 2?'':'non_rated'}}"></i>
    <i class="fas fa-star review_star {{$review->rating >= 3?'':'non_rated'}}"></i>
    <i class="fas fa-star review_star {{$review->rating >= 4?'':'non_rated'}}"></i>
    <i class="fas fa-star review_star {{$review->rating == 5?'':'non_rated'}}"></i>
</div>