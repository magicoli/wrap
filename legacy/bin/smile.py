import cv2
import sys

# Check if enough arguments were provided
if len(sys.argv) < 2:
    print("Usage: python3 face_detection.py <input_video> [<output_image>]")
    exit()

# Get the input and output filenames from the command-line arguments
input_file = sys.argv[1]
if len(sys.argv) > 2:
    output_file = sys.argv[2]
else:
    output_file = f"{input_file}.jpg"

# Load the input video
cap = cv2.VideoCapture(input_file)

# Initialize variables for the largest face found so far
max_area = 0
max_frame = None

# Load the face detection classifier
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + "haarcascade_frontalface_default.xml")

# Loop over all frames in the video
frame_num = 0
while True:
    # Read the next frame from the video
    success, frame = cap.read()

    if not success:
        # End of video
        break

    # Convert the frame to grayscale for face detection
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

    # Detect faces in the grayscale frame
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(30, 30))

    # Loop over all detected faces in the frame
    for (x, y, w, h) in faces:
        # Calculate the area of the face
        area = w * h

        # Update the largest face found so far
        if area > max_area:
            max_area = area
            max_frame = frame_num

    # Increment the frame counter
    frame_num += 1

# Set the video position to the frame with the largest face
cap.set(cv2.CAP_PROP_POS_FRAMES, max_frame)

# Read the frame with the largest face
success, frame = cap.read()

if not success:
    print("Error reading video")
    exit()

# Save the output image
cv2.imwrite(output_file, frame)

# Print the number of detected faces and the frame with the largest face
print(f"Detected {frame_num} frames and {len(faces)} faces in {input_file}.")
print(f"Extracted the frame with the largest face (frame {max_frame}). Output image saved as {output_file}.")
