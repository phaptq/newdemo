<div id="modal-terms" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Điều khoản và Quy định</h4>
            </div>
            <div class="modal-body">
                <?php
                    if (!\Cache::has('register_article')) {
                        \Cache::put('register_article', \App\Models\Article::where('status', 'terms')->first(), 1440);
                    }
                    $terms = \Cache::get('register_article');
                    echo $terms->content;
                 ?>
            </div>
        </div>
    </div>
</div>