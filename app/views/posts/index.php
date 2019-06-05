<?php require_once APPROOT . "/views/inc/header.php"; ?>
  <div class="row">
    <div class="col-md-6">
      <h1>Post</h1>
    </div>
    <div class="col-md-6">
      <a href="<?php echo URLROOT ?>/posts/add" class="btn btn-primary pull-right mb-3">
        <i class="fa fa-pencil"></i> Add Post
      </a>
    </div>
  </div>
  <?php flash("post_message"); ?>

  <?php foreach ($data["posts"] as $post) : ?>
      <div class="card card-body mb-3">
         <h4 class="card-title font-weight-bold"><?php echo $post->title; ?></h4>
         <p class="card-text pl-4"><?php echo nl2br($post->body); ?></p>
         <small class="bg-light p-2 mb-3"><i>Posted by <b><?php echo $post->name; ?></b> on <?php echo $post->postCreated; ?></i></small>
         <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-block col-md-1 ml-auto">
           More...
         </a>
      </div>
  <?php endforeach; ?>
<?php require_once APPROOT . "/views/inc/footer.php"; ?>
