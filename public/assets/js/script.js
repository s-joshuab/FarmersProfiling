function previewPhoto(event) {
    var input = event.target;
    var reader = new FileReader();
    
    reader.onload = function(){
      var image = document.getElementById('preview');
      image.src = reader.result;
    };
    
    reader.readAsDataURL(input.files[0]);
  }


  function generateReport() {
    // Fetch the selected values from the filters
    var barangay = document.getElementById('barangay').value;
    var commodity = document.getElementById('commodity').value;
    var is4psMember = document.getElementById('is_4ps_member').value;

    // Generate the PDF content
    var pdf = new jsPDF();
    pdf.setFontSize(18);
    pdf.text(20, 20, 'Filtered Reports');
    pdf.setFontSize(12);
    pdf.text(20, 30, 'Barangay: ' + barangay);
    pdf.text(20, 40, 'Commodity: ' + commodity);
    pdf.text(20, 50, '4Ps Member: ' + (is4psMember ? 'Yes' : 'No'));
    pdf.save('filtered_reports.pdf');

    // Create a new workbook
    var wb = XLSX.utils.book_new();
    var wsData = [];

    // Add header row
    wsData.push(["Barangay", "Commodity", "4Ps Member"]);

    // Add data rows
    wsData.push([barangay, commodity, (is4psMember ? 'Yes' : 'No')]);

    // Create worksheet and add data
    var ws = XLSX.utils.aoa_to_sheet(wsData);

    // Add worksheet to workbook
    XLSX.utils.book_append_sheet(wb, ws, "Filtered Reports");

    // Convert workbook to Excel file
    var wbout = XLSX.write(wb, { type: "binary", bookType: "xlsx" });

    // Save the Excel file
    saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), "filtered_reports.xlsx");
}

// Utility function to convert string to ArrayBuffer
function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xff;
    return buf;
}