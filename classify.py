import sys
import joblib
import numpy as np

# Check the number of command-line arguments
if len(sys.argv) < 3:
    print("Usage: python classify.py model_file feature1 feature2 ... feature25")
    sys.exit(1)

# Load the trained model
model_file = sys.argv[1]
data_to_classify = np.array(sys.argv[2:], dtype=float).reshape(1, -1)

# Load the model
model = joblib.load(model_file)

# Perform classification using the model
classification = model.predict(data_to_classify)[0]

# Map integer classification to meaningful label (replace with your labels)
classification_labels = {
    0: "Less chance of heart attack",
    1: "More chance of heart attack"
}

classified_label = classification_labels.get(classification, "Unknown")

print(classified_label)