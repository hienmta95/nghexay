
@if (Session::has('message'))
    <?php $paddingTopExists = true; ?>
    <script type="text/javascript">
        $.growl.error({ message: " {{ session('message') }}" });
    </script>
@endif

@if (Session::has('flash_notification'))
    <?php $paddingTopExists = true; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="flash-msg">
                @include('flash::message')
                </div>
            </div>
        </div>
    </div>
@endif

