<?php require APPROOT . '/views/inc/header.php' ?>

<div class="mb-4">
  <?php flash('post_message'); ?>
</div>

<div class="row mb-5">
  <div class="col-md-6 col-sm-6">
    <h1>Posts</h1>
  </div>

  <div class="col-md-6 col-sm-6">
    <a href="<?php URLROOT; ?>/shareposts/posts/add" class="btn btn-primary pull-right">
      <i class="fa fa-pencil"></i> Add Post
    </a>
  </div>
</div>

<?php foreach($data['posts'] as $post) : ?>
  <div class="card card-body mb-3">
    <h4 class="card-title"><?php echo $post->title; ?></h4>

    <p class="card-text">
      <?php echo $post->body; ?>
    </p>

    <div class="bg-light p-2">
      <p>Written By: <?php echo $post->name; ?> on <?php echo $post->created_at; ?></p>
    </div>

    <a href="<?php URLROOT; ?>/shareposts/posts/show/<?php echo $post->postID; ?>" class="btn btn-dark">More</a>
  </div>
<?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php' ?>