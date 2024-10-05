
import psycopg2

class Database:
    # Initialize the class (creating the constructor)
    def __init__(self):
        # Create connection with db
        self.connection = psycopg2.connect(
            dbname='pythonDB',
            user='postgres',
            password='12345',
            host='localhost',
            port=5432
        )
        self.cursor = self.connection.cursor()

    def get_all_records(self):
        print("Fetching all records...")
        self.cursor.execute('SELECT * FROM students.student')
        return self.cursor.fetchall()
    
    def insert_record(self, name, address):
        try:
            query = "INSERT INTO students.student (name, address) VALUES (%s, %s);"
            self.cursor.execute(query, (name, address))
            self.connection.commit()
            print(f"Inserted new record: Name={'vani'}, Address={'nimbalkarwadi'}.")
        except Exception as err:
            print(f"Error inserting record: {err}")

    def update_address(self, id, new_address):
        try:
            query = "UPDATE students.student SET address = %s WHERE id = %s;"
            self.cursor.execute(query, (new_address, id))
            self.connection.commit()
            print(f"Updated address for id {id} to {new_address}.")
        except Exception as err:
            print(f"Error updating address: {err}")

    def delete_record(self, id):
        try:
            query = "DELETE FROM students.student WHERE id = %s;"
            self.cursor.execute(query, (id,))
            self.connection.commit()
            print(f"Deleted record with id {id}.")
        except Exception as err:
            print(f"Error deleting record: {err}")

    def close(self):
        self.cursor.close()
        self.connection.close()
