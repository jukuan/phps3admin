#!/bin/bash

set -e

# Try to remove containers if they exist, ignore errors
docker-compose down || true

# Start containers
docker-compose up -d
