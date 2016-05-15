<?php
    $page="search";
    include("includes/header.php");
?>

<div class="l-side-by-side l-side-by-side--gutterless">


    <aside class="l-side-by-side__item">

        <div class="l-sidebar">

            <h2 class="heading heading--main h-spacing-base">Filters</h2>

                <form>

<?php
    include("includes/pet-details-form.php");
?>

                </form>

        </div>
    </aside>

    <div class="l-side-by-side__item">

        <main class="l-main" role="main">

            <h2 class="heading heading--main h-spacing-base">Pets</h2>

            <ul class="l-grid">

            <?php
                // get the posts
                $posts = get_posts();
                    if($posts){
                        foreach ($posts as $key => $post){
            ?>
                <li class="l-grid__item l-grid__item--4-col">

                    <div class="c-card">

                        <div class="c-card__header">
                            <h3 class="heading heading--main"><a href="/pet-details.php?pet=<?php echo substr($key, 1); ?>">Pet Name</a></h3>
                        </div>

                        <div class="c-card__body">
                            <ul>
                                <li>Species: <?php echo $post->breed; ?></li>
                                <li>Colour: <?php echo $post->colour; ?></li>
                                <li>Other info</li>
                            </ul>
                            <a href="/">I've found this pet!</a>
                        </div>
                    </div>
                    <!-- .c-card -->

                </li>

            <?php   }
                }
            ?>
            </ul>

        </main>

    </div>
    <!-- .l-side-by-side__item -->
</div>
<!-- .l-side-by-side -->

<?php
    include("includes/footer.php");
?>
