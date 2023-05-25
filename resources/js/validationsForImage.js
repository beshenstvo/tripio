// валидация размера изображения
export const maxSize = (maxSizeInKB) => {
    return (value) => {
        if (!value) return true;
        const fileSize = value.size / 1024; // to KB
        return fileSize <= maxSizeInKB;
    };
};

// валидация формата изображения
const allowedFormats = ['png', 'svg', 'jpeg', 'jpg'];
export const validFormat = (value) => {
if (!value) return true;
const fileExtension = value.name.split('.').pop().toLowerCase();
return allowedFormats.includes(fileExtension);
};