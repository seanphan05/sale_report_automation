<body>
<main id="main-holder">
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
    <article class="<?php post_class(); ?>" id="post-<?php the_ID(); ?>">
        <h2 class="entry-title"><?php the_title(); ?></h2>
        <?php if ( !is_page() ):?>
            <section class="entry-meta">
                <p>Posted on <?php the_date();?> by <?php the_author();?></p>
            </section>
        <?php endif; ?>
        <section class="entry-content">
            <?php the_content(); ?>
        </section>
        <section class="entry-meta"><?php if ( count( get_the_category() ) ) : ?>
                <span class="category-links">
        Posted under: <?php echo get_the_category_list( ', ' ); ?>
      </span>
            <?php endif; ?></section>
    </article>
<?php endwhile; ?>
<body>
<main id="main-holder">
<div id="login-page">
<div id="login-holder">
    <h2 id="login-header" style="text-align: center">Welcome to <br>Scratchers Report System</h2>
    <div><img id="login-image" src="wp-content/themes/lotterytheme/image/login-icon.png" alt="login-icon-image"></div>
    <div id="login-error-msg-holder" style="display: none"></div>
    <br>
    <form id="login-form" autocomplete="off">
        <input type="text" name="username" id="username-field" class="login-form-field" placeholder="Username">
        <input type="text" name="shift" id="shift-field" class="login-form-field" placeholder="Shift Time">
        <input type="password" name="password" id="password-field" class="login-form-field" placeholder="Verification Code">
        <input type="submit" value="Login" id="login-form-submit">
    </form>
</div>
</div>
<?php get_footer(); ?>

