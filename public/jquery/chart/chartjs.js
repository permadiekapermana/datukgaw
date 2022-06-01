$(function() {
  'use strict';

  // Bar chart
  if($('#belanjaPegawaiChart').length) {
    new Chart($("#belanjaPegawaiChart"), {
      type: 'bar',
      data: {
        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
          {
            label: "Jumlah Belanja Pegawai",
            backgroundColor: ["#b1cfec","#7ee5e5","#66d1d1","#f77eb9","#4d8af0","#b1cfec","#7ee5e5","#66d1d1","#f77eb9","#4d8af0","#b1cfec","#7ee5e5"],
            data: [2478, 5267, 734, 2084, 1433, 2345, 3456, 4567, 5678, 6789, 7890, 8901]
          }
        ]
      },
      options: {
        legend: { display: false },
      }
    });
  }

  if($('#belanjaBarangChart').length) {
    new Chart($("#belanjaBarangChart"), {
      type: 'bar',
      data: {
        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
          {
            label: "Jumlah Belanja Barang",
            backgroundColor: ["#b1cfec","#7ee5e5","#66d1d1","#f77eb9","#4d8af0","#b1cfec","#7ee5e5","#66d1d1","#f77eb9","#4d8af0","#b1cfec","#7ee5e5"],
            data: [2478, 5267, 734, 2084, 1433, 2345, 3456, 4567, 5678, 6789, 7890, 8901]
          }
        ]
      },
      options: {
        legend: { display: false },
      }
    });
  }

  if($('#belanjaModalChart').length) {
    new Chart($("#belanjaModalChart"), {
      type: 'bar',
      data: {
        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
          {
            label: "Jumlah Belanja Modal",
            backgroundColor: ["#b1cfec","#7ee5e5","#66d1d1","#f77eb9","#4d8af0","#b1cfec","#7ee5e5","#66d1d1","#f77eb9","#4d8af0","#b1cfec","#7ee5e5"],
            data: [2478, 5267, 734, 2084, 1433, 2345, 3456, 4567, 5678, 6789, 7890, 8901]
          }
        ]
      },
      options: {
        legend: { display: false },
      }
    });
  }

});