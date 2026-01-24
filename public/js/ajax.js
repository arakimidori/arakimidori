function loadSort(){
    $('#table3').tablesorter();
}

document.addEventListener("DOMContentLoaded", function () {
    console.log("あいうえお");
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
                        <tr>
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
                            <td><td>${product.company.company_name}</td></td>
                            <td><a href="/show/${product.id}">詳細</a></td>
                            <td>
                                <form action="/products/${product.id}" method="POST"
                                    onsubmit="return confirm('本当に削除しますか？');">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit">削除</button>
                                </form>
                            </td>
                        </tr>
                    `;
                });
            });
    });
});
