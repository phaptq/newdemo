<div id="modal-contact" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <?php
                    if (!\Cache::has('contact_modal')) {
                        \Cache::put('contact_modal', \App\Models\Article::where('status', 'contact')->first(), env('CACHE_TIME'));
                    }
                    $contact = \Cache::get('contact_modal');
                 ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{$contact->title}}</h4>
            </div>
            <div class="modal-body">
                {!!$contact->content!!}
            </div>
        </div>
    </div>
</div>