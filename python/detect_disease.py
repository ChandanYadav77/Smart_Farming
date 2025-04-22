import sys
import cv2
import numpy as np
from tensorflow.keras.models import load_model

model = load_model("model.h5")

def predict_disease(image_path):
    img = cv2.imread(image_path)
    img = cv2.resize(img, (128, 128))
    img = np.expand_dims(img, axis=0) / 255.0

    prediction = model.predict(img)
    classes = ["Healthy", "Leaf Blight", "Rust", "Mosaic Virus"]
    
    return classes[np.argmax(prediction)]

if __name__ == "__main__":
    image_path = sys.argv[1]
    print(predict_disease(image_path))
