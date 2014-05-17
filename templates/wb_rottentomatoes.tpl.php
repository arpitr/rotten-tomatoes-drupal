<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

  <div class="movie-listing__info-block1">
    <div class="">Rotten ID:  <?php print $movie['id']; ?> </div>
    <div class="">IMDB ID:  <?php print $movie['alternate_ids']['imdb']; ?> </div>
    <div class="">Movie Title   <?php print $movie['title']; ?> </div>
    <div class="">Year:   <?php print $movie['year']; ?> </div>
    <div class="">Critics Consensus:   <?php print $movie['critics_consensus']; ?> </div>
    <div class="">Release Date  <?php print $movie['release_dates']['theater']; ?></div>
    <div class="">IMDB ID:  <?php print $movie['alternate_ids']['imdb']; ?> </div>
  </div>

  <div class="movie-listing__info-block2">
    <div class="movie-rating">Ratings
      <div class="critics-rating">Critics Rating <?php print $movie['ratings']['critics_rating']; ?> </div>
      <div class="critics-score">Critics Score <?php print $movie['ratings']['critics_score']; ?> </div>
      <div class="audience-rating">Audience Rating <?php print $movie['ratings']['audience_rating']; ?> </div>
      <div class="audience-score">Audience Score <?php print $movie['ratings']['audience_score']; ?> </div>
    </div>
  </div>

  <div class="movie-listing__info-block3">
    <div class="movie-casting">Casting <?php print $movie_casting; ?> </div>
  </div>

  <div class="movie-listing__info-block4">
    <div class="synopsis">Synopsis: <?php print $movie['synopsis']; ?> </div>
  </div>