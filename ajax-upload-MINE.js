var ajaxup = {
  // (A) ADD TO UPLOAD QUEUE
  queue : [], // upload queue
  add : () => {
    for (let f of document.getElementById("upfile").files) {
      ajaxup.queue.push(f);
    }
    document.getElementById("upform").reset();
    if (!ajaxup.uploading) { ajaxup.go(); }
    return false;
  },

  // (B) AJAX UPLOAD
  uploading : false, // upload in progress
  go : () => {
    // (B1) UPLOAD ALREADY IN PROGRESS
    ajaxup.uploading = true;
 
    // (B2) FILE TO UPLOAD
    var data = new FormData();
    data.append("upfile", ajaxup.queue[0]);
    // APPEND MORE VARIABLES IF YOU WANT
    // data.append("KEY", "VALUE");
    const q = document.getElementById('quality').value;
    const w = document.getElementById('width').value;

    // FormData.append('quality', q);
    // FormData.append('width',   w);
    data.append('quality', q);
    data.append('width',   w);

    // (B3) FETCH UPLOAD
    fetch("ajax-upload.php", {
      method:"POST", 
      body:data 
    })
    .then(res=>res.text()).then((res) => {

    // (B4) SHOW UPLOAD RESULTS
    // document.getElementById("upstat").innerHTML += `<div>${ajaxup.queue[0].name} - ${res}</div>`;
    document.getElementById("upstat").innerHTML 
          += `${ajaxup.queue[0].name}  - ${res}`
          ;
    //    += `Source file: ${ajaxup.queue[0].name} - ${res} <br> Created: `

    // (B5) NEXT FILE
    ajaxup.queue.shift();
      if (ajaxup.queue.length!=0) 
        { ajaxup.go(); }
      else 
        { ajaxup.uploading = false; }
    })
    .catch((err) => { console.error(err) });
  }
};
