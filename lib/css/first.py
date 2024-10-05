import first


def show_records():
    db = first.Database()
    records = db.get_all_records()
    print("Records:", records)

    # Update the address of id 3 from 'Latur' to 'Pune'
    db.update_address(3, "Pune")

    # Display records after update
    updated_records = db.get_all_records()
    print("Records after update:", updated_records)

    db.delete_record(2)

    delete_records = db.get_all_records()
    print("Records after delete:", delete_records)

    # Optionally, delete a record (for demonstration)
    # Uncomment the following line to delete a record with id 4
    # db.delete_record(4)

    db.close()


show_records()
