const formData = new FormData();
const photos   = document.querySelector('input[type="file"][multiple]');
const q = document.getElementById('quality').value;
const w = document.getElementById('width').value;

for (let i = 0; i < photos.files.length; i++)
{
  formData.append(`photos_${i}`, photos.files[i]);
}
formData.append('quality', q);
formData.append('width',   w);

// fetch('https://example.com/posts', {
  fetch('ajax-upload.php', {
    method: 'POST',
    body: formData,
  } )

.then(response => response.json())
.then(result   => {
  console.log('Success:', result);
})

.catch(error => {
  // console.error('Error:', error);
  // alert("JSON ==> "  + response.json() );
  // alert("error ==> " + error);
  // console.error('Error:', error.message);
});

/*
error ==> SyntaxError: 
  JSON.parse: unexpected character at line 1 column 2 of the JSON data
*/