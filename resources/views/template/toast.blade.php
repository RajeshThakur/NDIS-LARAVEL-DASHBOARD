<script type="text/html" id="tmpl-toast">
    <div class="toast" id="<%= data.id %>" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <%= data.icon %>
            <strong class="mr-auto"><%= data.title %></strong>
            <small class="text-muted"><%= data.time %></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <%= data.content %>
        </div>
    </div>
</script>