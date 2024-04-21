import base64

with open("Capture.png", "rb") as image_file:
    image_data = image_file.read()
encoded_image = base64.b64encode(image_data).decode("utf-8")
open('f.txt','w').write(encoded_image)
# Use 'encoded_image' in your application
