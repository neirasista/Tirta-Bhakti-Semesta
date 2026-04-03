document.addEventListener("DOMContentLoaded", () => {

    // ============================
    // MODAL TAMBAH
    // ============================
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const modal = document.getElementById("modal");
    const addForm = document.getElementById("addForm");

    openModal?.addEventListener("click", () => modal.classList.remove("hidden"));
    closeModal?.addEventListener("click", () => modal.classList.add("hidden"));

    modal?.addEventListener("click", (e) => {
        if (e.target === modal) modal.classList.add("hidden");
    });

    addForm?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(addForm);

        const res = await fetch("/admin/orderdata", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json",
            },
            body: formData
        });

        if (res.ok) {
            window.location.reload();
        } else {
            const err = await res.json().catch(()=>null);
            console.error(err);
            alert("Gagal menambahkan data!");
        }
    });


    // ============================
    // MODAL EDIT
    // ============================
    const editModal = document.getElementById("editModal");
    const closeEditModal = document.getElementById("closeEditModal");
    const editForm = document.getElementById("editForm");

    document.querySelectorAll(".btn-edit").forEach((btn) => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;

            const res = await fetch(`/admin/orderdata/${id}/edit`, {
                headers: { "Accept": "application/json" }
            });
            if (!res.ok) return alert("Gagal mengambil data!");

            const data = await res.json();

            editForm.dataset.id = id;
            document.getElementById("editNama").value = data.nama || "";
            document.getElementById("editLuas").value = data.luasarea || "";
            document.getElementById("editTelp").value = data.notelp || "";
            document.getElementById("editTanggal").value = data.tanggal_order || "";
            document.getElementById("editGrade").value = data.grade_id || "";
            document.getElementById("editTankType").value = data.tank_type || "tanam";

            editModal.classList.remove("hidden");
        });
    });

    closeEditModal?.addEventListener("click", () => editModal.classList.add("hidden"));

    editModal?.addEventListener("click", (e) => {
        if (e.target === editModal) editModal.classList.add("hidden");
    });

    // ✅ UPDATE pakai POST + override PUT (AMAN buat FormData)
    editForm?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const id = editForm.dataset.id;
        const formData = new FormData(editForm);

        const res = await fetch(`/admin/orderdata/${id}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "X-HTTP-Method-Override": "PUT",
                "Accept": "application/json",
            },
            body: formData
        });

        if (res.ok) {
            window.location.reload();
        } else {
            const err = await res.json().catch(()=>null);
            console.error(err);
            alert("Gagal menyimpan perubahan!");
        }
    });


    // ============================
    // MODAL DELETE
    // ============================
    const deleteModal = document.getElementById("deleteModal");
    const deleteTarget = document.getElementById("deleteTarget");
    const cancelDelete = document.getElementById("cancelDelete");
    const confirmDelete = document.getElementById("confirmDelete");

    document.querySelectorAll(".btn-delete").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;

            deleteModal.classList.remove("hidden");
            deleteTarget.textContent = `Yakin ingin menghapus "${nama}"?`;

            confirmDelete.onclick = async () => {
                const res = await fetch(`/admin/orderdata/${id}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "X-HTTP-Method-Override": "DELETE",
                        "Accept": "application/json",
                    }
                });

                if (res.ok) {
                    window.location.reload();
                } else {
                    alert("Gagal menghapus data!");
                }
            };
        });
    });

    cancelDelete?.addEventListener("click", () => deleteModal.classList.add("hidden"));

    deleteModal?.addEventListener("click", (e) => {
        if (e.target === deleteModal) deleteModal.classList.add("hidden");
    });


    // ============================
    // PROFILE MENU
    // ============================
    const profileButton = document.getElementById("profileButton");
    const profileMenu = document.getElementById("profileMenu");

    profileButton?.addEventListener("click", () => {
        profileMenu.classList.toggle("hidden");
    });

    window.addEventListener("click", (e) => {
        if (!profileButton.contains(e.target) && !profileMenu.contains(e.target)) {
            profileMenu.classList.add("hidden");
        }
    });

});
