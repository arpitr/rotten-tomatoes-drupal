<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Helper function to return basic info from twitter account object.
 *
 */

  <div class="movie-listing__info-block1">
    Rotten ID:  <?php print $movie['id']; ?>
    IMDB ID:  <?php print $movie['alternate_ids']['imdb']; ?>
    Movie Title   <?php print $movie['title']; ?>
    Year:   <?php print $movie['year']; ?>
    Critics Consensus:   <?php print $movie['critics_consensus']; ?>
    Release Date  <?php print $movie['release_dates']['theater']; ?>
    IMDB ID:  <?php print $movie['alternate_ids']['imdb']; ?>
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
    Synopsis: <?php print $movie['synopsis']; ?> </div>
  </div>