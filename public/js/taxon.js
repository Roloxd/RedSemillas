const table = $("#example1")
  .DataTable({
    fixedHeader: {
      header: true,
    },
    responsive: true,
    lengthChange: false,
    autoWidth: false,
  })
  .buttons()
  .container()
  .appendTo("#example1_wrapper .col-md-6:eq(0)");

let datosTablaCache = [];

// checkbox.addEventListener("change", function () {
//   this.checked ? console.log("check") : console.log("no check");
// });

// $("#example1 tbody tr").on("click", function (e) {
//   if ($(e.target).is(":checkbox")) {
//     console.log(table.row(this).data());
//     if ($(this).hasClass("selected")) {
//       $(this).removeClass("selected");
//     } else {
//       // table.$("tr.selected").removeClass("selected");
//       $(this).addClass("selected");
//     }
//     datosTablaCache.push(table.row(this).data());
//     // var $cb = $(this).find(":checkbox");
//     // $cb.prop("checked", !$cb.is(":checked"));
//   }
// });

// const table = $("#example1").DataTable({
//   columnDefs: [
//     {
//       orderable: false,
//       className: "select-checkbox",
//       targets: 0,
//     },
//   ],
//   select: {
//     style: "os",
//     selector: "td:first-child",
//   },
//   order: [[1, "asc"]],
// });

// async function getData() {
//   const response = await fetch("http://localhost/admin/taxon/wfo");
//   const data = await response.json();

//   console.log(data);
//   return data;
// }
// function selectedPage(num) {
//   (async () => {
//     const rawResponse = await fetch("http://localhost/admin/taxon/wfo/post", {
//       method: "POST",
//       headers: {
//         Accept: "application/json",
//         "Content-Type": "application/json",
//       },
//       body: JSON.stringify({ pagina: num }),
//     });
//     const content = await rawResponse.json();

//     console.log(content);
//   })();
//   getData();
// }

// (async () => {
//   const rawResponse = await fetch("http://localhost/admin/taxon/wfo/post", {
//     method: "POST",
//     headers: {
//       Accept: "application/json",
//       "Content-Type": "application/json",
//     },
//     body: JSON.stringify({ pagina: num }),
//   });
//   const content = await rawResponse.json();

//   console.log(content);
// })();
