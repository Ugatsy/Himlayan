<div id="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 50; align-items: center; justify-content: center;">
    <div style="background: white; padding: 24px; border-radius: 8px; width: 400px; max-width: 90%;">
        <h3 style="margin-top: 0;" id="modal-title">Add Burial Spot</h3>
        <form method="POST" action="{{ route('burial-spots.store') }}" id="burial-form">
            @csrf
            <div style="margin-bottom: 12px;">
                <input name="name" type="text" placeholder="Full name" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 12px;">
                <input name="plot_number" type="text" placeholder="e.g. A-12" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 12px;">
                <input name="section" type="text" placeholder="e.g. Block 3, Row B" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 12px; display: flex; gap: 8px;">
                <input name="birth_year" type="number" placeholder="Birth year" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <input name="death_year" type="number" placeholder="Death year" style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 12px;">
                <select name="status" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="occupied">Occupied</option>
                    <option value="reserved">Reserved</option>
                    <option value="available" selected>Available</option>
                </select>
            </div>
            <div style="margin-bottom: 12px;">
                <textarea name="notes" placeholder="Notes" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; min-height: 60px;"></textarea>
            </div>
            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="padding: 8px 16px; border: 1px solid #ccc; border-radius: 4px; background: white; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 8px 16px; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer;">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modal-overlay').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modal-overlay').style.display = 'none';
    }
</script>