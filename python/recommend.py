import sys

soil = sys.argv[1].lower()
temp = float(sys.argv[2])
humidity = float(sys.argv[3])

if soil == "sandy":
    crops = "Millets, Sorghum, Groundnut"
elif soil == "clay":
    crops = "Paddy, Sugarcane, Wheat"
elif soil == "loamy":
    crops = "Maize, Barley, Sunflower"
else:
    crops = "Rice, Maize, Cotton"

print(crops)
