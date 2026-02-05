console.log("ajax.js 読み込まれてる");
function loadSort() {
    
  $('#table3').tablesorter({
    theme: 'default',
    headers: {
      0: { sorter: false },
      1: { sorter: false },
      2: { sorter: false },
      3: { sorter: "digit" }, // 価格
      4: { sorter: "digit" }, // 在庫
      5: { sorter: false },
      6: { sorter: false },
      7: { sorter: false }
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
    
loadSort();

$(document).on('click', '.delete-btn', function () {
    if (!confirm('本当に削除しますか？')) return;

    const productId = $(this).data('id');

    fetch(`/products/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error();
        return res.json();
    })
    .then(() => {
        // 行を消す
        document.getElementById(`product-${productId}`).remove();
    })
    .catch(() => {
        alert('削除に失敗しました');
    });
});

    const form = document.getElementById("searchForm");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // 画面遷移を止める


        const formData = new FormData(this);
        const params = new URLSearchParams(formData);

        fetch("/products/ajax-search?" + params.toString())
            .then((res) => res.json())
            .then((data) => {
                const tbody = document.getElementById("productList");
                tbody.innerHTML = "";

                data.forEach((product) => {
                    tbody.innerHTML += `
                        <tr id="product-${product.id}">
                            <td>${product.id}</td>
                            <td>
                                ${
                                    product.img_path
                                        ? `<img src="/${product.img_path}" width="80">`
                                        : "画像なし"
                                }
                            </td>
                            <td>${product.company.company_name}</td>
                            <td>${product.price}</td>
                            <td>${product.stock}</td>
                            <td>${product.company.company_name}</td>
                            <td><a href="/show/${product.id}">詳細</a></td>
                            <td>
                                <button class="delete-btn" data-id="${product.id}"> 削除</button>
                            </td>
                        </tr>
                    `;
                });
                $("#table3").trigger("update");
            });
    });
});
