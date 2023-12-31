/**
 * Resize a base 64 Image
 * @param {String} base64Str - The base64 string (must include MIME type)
 * @param {Number} MAX_WIDTH - The width of the image in pixels
 * @param {Number} MAX_HEIGHT - The height of the image in pixels
 */
async function reduce_image_file_size(base64Str, MAX_WIDTH = 1280, MAX_HEIGHT = 720) {
    let resized_base64 = await new Promise((resolve) => {
        let img = new Image()
        img.src = base64Str
        img.onload = () => {
            let canvas = document.createElement('canvas')
            let width = img.width
            let height = img.height

            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width
                    width = MAX_WIDTH
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height
                    height = MAX_HEIGHT
                }
            }
            canvas.width = width
            canvas.height = height
            let ctx = canvas.getContext('2d')
            ctx.drawImage(img, 0, 0, width, height)
            resolve(canvas.toDataURL("image/jpeg")) // this will return base64 image results after resize

        }
    });

    return resized_base64;
}


async function image_to_base64(file) {
    let result_base64 = await new Promise((resolve) => {
        let fileReader = new FileReader();
        fileReader.onload = (e) => resolve(fileReader.result);
        fileReader.onerror = (error) => {
            // console.log(error)
            alert('An Error occurred please try again, File might be corrupt');
        };
        fileReader.readAsDataURL(file);
    });
    return result_base64;
}

async function process_image(file, min_image_size = 300) {
    const res = await image_to_base64(file);
    if (res) {
        const old_size = calc_image_size(res);
        if (old_size > min_image_size) {
            const resized = await reduce_image_file_size(res);
            const new_size = calc_image_size(resized)
            // console.log('new_size=> ', new_size, 'KB');
            // console.log('old_size=> ', old_size, 'KB');
            var type = localStorage.getItem("type");
            if (type == 1) {
                $("#foto_lok").val(resized);
                document.getElementById("lokasi").style.setProperty("background-color", "green", "important");
                document.getElementById("lokasi").classList.add("sukses");
                document.getElementById("lokasi").style.setProperty("border-color", "green", "important");
            } else if (type == 2) {
                $("#foto_sampl").val(resized);
                document.getElementById("sample").style.setProperty("background-color", "green", "important");
                document.getElementById("sample").classList.add("sukses");
                document.getElementById("sample").style.setProperty("border-color", "green", "important");
            } else {
                $("#foto_lain").val(resized);
                document.getElementById("lain").style.setProperty("background-color", "green", "important");
                document.getElementById("lain").classList.add("sukses");
                document.getElementById("lain").style.setProperty("border-color", "green", "important");
            }
            localStorage.clear();
            return resized;
        } else {
            // console.log('image already small enough');
            var type = localStorage.getItem("type");
            if (type == 1) {
                $("#foto_lok").val(res);
                document.getElementById("lokasi").style.setProperty("background-color", "green", "important");
                document.getElementById("lokasi").classList.add("sukses");
                document.getElementById("lokasi").style.setProperty("border-color", "green", "important");
            } else if (type == 2) {
                $("#foto_sampl").val(res);
                document.getElementById("sample").style.setProperty("background-color", "green", "important");
                document.getElementById("sample").classList.add("sukses");
                document.getElementById("sample").style.setProperty("border-color", "green", "important");
            } else {
                $("#foto_lain").val(res);
                document.getElementById("lain").style.setProperty("background-color", "green", "important");
                document.getElementById("lain").classList.add("sukses");
                document.getElementById("lain").style.setProperty("border-color", "green", "important");
            }
            localStorage.clear();
            return res;
        }

    } else {
        // console.log('return err')
        return null;
    }
}

/*- NOTE: USE THIS JUST TO GET PROCESSED RESULTS -*/
async function preview_image(no) {
    // console.log(no);
    localStorage.setItem("type", no);
    if (no == 1) {
        var file = document.getElementById('file1');
    } else if (no == 2) {
        var file = document.getElementById('file2');
    } else {
        var file = document.getElementById('file3');
    }
    const image = await process_image(file.files[0]);
    // console.log(image)
}

/*- NOTE: USE THIS TO PREVIEW IMAGE IN HTML -*/
// async function preview_image() {
//     const file = document.getElementById('file');
//     const res = await image_to_base64(file.files[0])
//     if (res) {
//         document.getElementById("old").src = res;

//         const olds = calc_image_size(res)
//         console.log('Old ize => ', olds, 'KB')

//         const resized = await reduce_image_file_size(res);
//         const news = calc_image_size(resized)
//         console.log('new size => ', news, 'KB')
//         document.getElementById("new").src = resized;
//     } else {
//         console.log('return err')
//     }
// }


function calc_image_size(image) {
    let y = 1;
    if (image.endsWith('==')) {
        y = 2
    }
    const x_size = (image.length * (3 / 4)) - y
    return Math.round(x_size / 1024)
}


// credit to: https://gist.github.com/ORESoftware/ba5d03f3e1826dc15d5ad2bcec37f7bf 