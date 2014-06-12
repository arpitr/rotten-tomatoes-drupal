<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

  <div class="movie-listing__info-block1">
    <?php if (isset($movie['id'])): ?>
      <div class="">Rotten ID:  <?php print $movie['id']; ?> </div>
    <?php endif; ?>
      
    <?php if (isset($movie['alternate_ids']['imdb'])): ?>
      <div class="">IMDB ID:  <?php print $movie['alternate_ids']['imdb']; ?> </div>
    <?php endif; ?>
      
    <?php if (isset($movie['title'])): ?>
      <div class="">Movie Title   <?php print $movie['title']; ?> </div>
    <?php endif; ?>

    <?php if (isset($movie['year'])): ?>
      <div class="">Year:   <?php print $movie['year']; ?> </div>
    <?php endif; ?>

    <?php if (isset($movie['critics_consensus'])): ?>
      <div class="">Critics Consensus:   <?php print $movie['critics_consensus']; ?> </div>
    <?php endif; ?>
    
    <?php if (isset($movie['release_dates']['theater'])): ?>
      <div class="">Release Date  <?php print $movie['release_dates']['theater']; ?></div>
    <?php endif; ?>

    <?php if (isset($movie['alternate_ids']['imdb'])): ?>
      <div class="">IMDB ID:  <?php print $movie['alternate_ids']['imdb']; ?> </div>
    <?php endif; ?>
  </div>

  <div class="movie-listing__info-block2">
    <div class="movie-rating">Ratings
      <?php if (isset($movie['ratings']['critics_rating'])): ?>
        <div class="critics-rating">Critics Rating <?php print $movie['ratings']['critics_rating']; ?> </div>
      <?php endif; ?>

      <?php if (isset($movie['ratings']['critics_score'])): ?>
        <div class="critics-score">Critics Score <?php print $movie['ratings']['critics_score']; ?> </div>
      <?php endif; ?>

      <?php if (isset($movie['ratings']['audience_rating'])): ?>
        <div class="audience-rating">Audience Rating <?php print $movie['ratings']['audience_rating']; ?> </div>
      <?php endif; ?>

      <?php if (isset($movie['ratings']['audience_score'])): ?>
        <div class="audience-score">Audience Score <?php print $movie['ratings']['audience_score']; ?> </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="movie-listing__info-block3">
    <?php if (isset($movie_casting)): ?>
      <div class="movie-casting">Casting <?php print $movie_casting; ?> </div>
    <?php endif; ?>
  </div>

  <div class="movie-listing__info-block4">
    <?php if (isset($movie['synopsis'])): ?>
      <div class="synopsis">Synopsis: <?php print $movie['synopsis']; ?> </div>
    <?php endif; ?>
  </div>