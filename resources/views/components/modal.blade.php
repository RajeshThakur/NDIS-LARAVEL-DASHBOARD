<div class="modal micromodal-slide" id="modal-2" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-custom-close>
        <div class="modal__container w-90 w-40-ns" role="dialog" aria-modal="true" aria-labelledby="modal-2-title">
            <header class="modal__header">
            <h3 class="modal__title" id="modal-2-title">
                🔒 Login
            </h3>
            <button class="modal__close" aria-label="Close modal" data-custom-close></button>
            </header>
            <form class="black-80" action="/">
            <div class="modal__content" id="modal-2-content">
                <div class="measure">
                    <label for="name" class="f6 b db mb2 js-name">Name</label>
                    <input id="name" class="input-reset ba b--black-20 pa2 mb2 db w-100 js-nameInput" type="text">

                    <label for="password" class="f6 b db mb2 mt3">Password <span class="normal black-60">(required)</span></label>
                    <input id="password" class="input-reset ba b--black-20 pa2 mb2 db w-100" type="password" required>
                    <small id="name-desc" class="f6 black-60 db mb2">Must be atleast 6 characters long.</small>
                </div>
            </div>
            <footer class="modal__footer">
                <input type="submit" class="modal__btn modal__btn-primary" value="Login"/>
                <a class="f6 ml2 dark-blue no-underline underline-hover js-modal-close-trigger" href="#" aria-label="Close this dialog window">Cancel</a>
            </footer>
            </form>
        </div>
    </div>
</div>