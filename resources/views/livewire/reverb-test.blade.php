<div>
    <form wire:submit.prevent="submitForm" class="container">
        <div class="form-group">
            <label for="inputValue">Input:</label>
            <input type="text" class="form-control" id="inputValue" wire:model="name">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <script>
        Echo.channel('my-channel')
        .listen('RoomCreated', (e) => {
        console.log('adsf');
        });
    </script>
</div>
