public class MainActivity extends Activity {
    //사용자 정의 함수로 블루투스 활성 상태의 변경 결과를 App으로 알려줄때 식별자로 사용된(0보다 커야함)
    static final int REQUEST_ENABLE_BT = 10;
    int mPariedDeviceCount = 0;
    Set<BluetoothDevice> mDevices;
    //폰의 블루투스 모듈을 사용하기 위한 오브젝트
    BluetoothAdapter mBluetoothAdapter;
    /**
     * BluetoothDevice로 기기의 장치정보를 알아낼 수 있는 자세한 메소드 및 상태값을 알아낼 수 있다
     * 연결하고자 하는 다른 블루투스 기기의 이름, 주소, 연결 상태 들의 장보를 조뢰할 수 있는 클래스
     * 현재 기기가 아닌 다른 블루투스 기기와의 연결 및 정보를 알아낼 떄 사용
     */
    BluetoothDevice mRemoteDevice;
    //스마트폰과 페어링 된 디바이스간 통신 채널에 대응 하는 BluetoothSocket
    BluetoothSocket mSocket = null;
    OutputStream mOutputStream = null;
    InputStream mInputStream = null;
    String mStrDelimiter = "\n";
    char mCharDelimiter = '\n';

    Thread mWorkerThread = null;
    byte[] readBuffer;
    int readBufferPosition;

    Button mButtonConnect;
    TextView mname, mnum;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        mname = (TextView)findViewById(R.id.name);
        mnum = (TextView)findViewById(R.id.num);
        mButtonConnect = (Button) findViewById(R.id.connnct);

        mButtonConnect.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //연결 버튼을 눌렀을 때
                selectDevice();
            }
        });

        //블루투스 활성화 시키는 메소드
        checkBluetooth();
    }

    //블루투스 장치의 이름이 주어졌을때 해당 블루투스 장치 객체를 페어링 된 장치 목록에서 찾아내는 코드
    BluetoothDevice getDeviceFromBondedList(String name){
        //BluetoothDevice : 페어링 된 기기 목록을 얻어옴
        BluetoothDevice selectedDevice = null;
        //getBondedDevice 함수가 반환하는 페어링 된 기기 목록은 Set 형식이며,
        //Set 형식에서는 n번째 원소를 얻어오는 방법이 없으므로 주어진 이름과 비교해서 찾는다
        for(BluetoothDevice device : mDevices){
            //getName() : 단말기의 Bluetooth Adapter 이름을 반환
            if(name.equals(device.getName())){
                selectedDevice = device;
                break;
            }
        }
        return selectedDevice;
    }

    //connectToSelectedDevice() : 원격 장치롸 연결하는 과정을 나타냄
    // 실제 데이터 송수신을 위해서는 소켓으로부터 입출력 스트림을 얻고 스트림을 이용하여 이루어진다.
    private void connectToSelectedDevice(String selectDeviceName) {
        //BluetoothDevice원격 블루투스 기기를 나타냄
        mRemoteDevice = getDeviceFromBondedList(selectDeviceName);
        //java.util.UUID.fromString : 자바에서 중복되지 않는 Unique키 생성
        UUID uuid = java.util.UUID.fromString("00001101-0000-1000-8000-00805f9b34fb");

        try{
            //소켓 생성, RFCOMM 채널을 통한 연결
            //createRfcommSocketToServiceRecoed(uuid): 이 함수를 사용하여 원격 블루투스 장치와 통신할수 있는 소켓을 생성함
            //이 메소드가 성공하면 스마트폰과 페어링 된 디바이스 간 통신 채널에 대응하는 BluetoothSocket오브젝트를 리턴함
            mSocket = mRemoteDevice.createRfcommSocketToServiceRecord(uuid);
            mSocket.connect(); // 소켓이 생성 되면 connect() 함수를 호출함으로써 두기기의 연결은 완료된다.

            //데이터 송수신을 위한 스트림 얻기
            //BluetoothSocket 오브젝트는 두개의 Stream을 제공한다
            // 1. 데이터를 보내기 위한 OutputStream
            //2. 데이터를 받기 위한 InputStream
            mOutputStream = mSocket.getOutputStream();
            mInputStream = mSocket.getInputStream();

            //데이터 수신 준비
            beginListenForData();

        } catch (Exception e) { //블루투스 연결 중 오류 발생
            Toast.makeText(getApplicationContext(), "블루투스 연결 중 오류가 발생했습니다", Toast.LENGTH_LONG).show();
        }
    }

    void beginListenForData() {
       final Handler handler = new Handler();

       readBuffer = new byte[1024]; // 수신버퍼
        readBufferPosition = 0; //버퍼 내 수신 문자 저장 위차

        //문자열 수신 쓰레드
        mWorkerThread = new Thread(new Runnable() {
            @Override
            public void run() {
                //interrupt() 메소드를 이용 스레드를 종료 시키는 예제이다
                //interrupt() 메소드는 하던 일을 멈추는 메소드이다.
                //isinterrupted() 메소드를 사용하여 멈추었을 경우 반복문을 나가서 스레드가 종료하게 된다
                while(!Thread.currentThread().isInterrupted()){
                    try{
                        //inputStream.available() : 다른 스레드 레서 blocking 하기 정까지 읽은 수 있는 문자열 개수를 반환함
                        int byteAvailable = mInputStream.available(); //수신 데이터 확인
                        if(byteAvailable > 0) { // 데이터가 수신된 경우 (9바이트 이상만 수신 받고 싶으면 여기 수정)
                            byte[] packetByte = new byte[byteAvailable];
                            //read(buf[]) : 입력스트림에서 buf[] 크기만큼 읽어서 저장 없을 경우에 -1 리턴
                            mInputStream.read(packetByte);
                            for(int i=0; i<byteAvailable; i++) {
                                byte b = packetByte[i];
                                if(b == mCharDelimiter) {
                                    byte[] encodedByte = new byte[readBufferPosition];
                                    // System.arraycopy (복사할 배열, 복사 시작점, 복사된 배열, 붙이기 시작점, 복사할 개수)
                                    //readBuffer 배열을 처음부터 끝까지 encodedByte 배열로 복사
                                    System.arraycopy(readBuffer, 0, encodedByte, 0, encodedByte.length);

                                    final String data = new String(encodedByte, "US-ASCII");
                                    readBufferPosition = 0;

                                    // while 문 사용, 10초 마다 수신 받기
                                    while (true) {
                                        handler.postDelayed(new Runnable() {
                                            //수신된 문자열 데이터에 대한 처리 작업
                                            @Override
                                            public void run() {
                                                mnum.setText(mnum.getText().toString() + data + mStrDelimiter);
                                            }
                                        }, 10000); //10초 딜레이를 줌
                                    }

                                }else{
                                    readBuffer[readBufferPosition++] = b;
                                }
                            }

                        }
                    }catch (Exception e){
                        //데이터 수신 중 올 발생
                        Toast.makeText(getApplicationContext(), "데이터 수신 중 오류가 발생 했습니다.", Toast.LENGTH_SHORT).show();
                        finish();
                    }
                }
            }
        });

        mWorkerThread.start();
    }

    // 블루투스 지원하며 활성 상태인 경우
    private void selectDevice() {
        //블루투스 디바이스는 연결해서 사용하기 전에 먼저 페어링 되어야만한다
        //getBondedDevice() : 페어링된 장치 목록 얻어오는 함수
        mDevices = mBluetoothAdapter.getBondedDevices();
        mPariedDeviceCount = mDevices.size();

        if(mPariedDeviceCount == 0){ // 페어링된 장치가 없는 경우
            Toast.makeText(getApplicationContext(),"페어링된 장치가 없습니다",Toast.LENGTH_LONG).show();
            finish();//앱 종료
        }
        //페어링 된 장치가 있는 경우
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("블루투스 장치 선택");

        //각 디바이스는 이름과(서로 다른) 주소를 가진다. 페어링된 디바이스들을 표시한다.
        List<String> listItem = new ArrayList<String>();
        for(BluetoothDevice device : mDevices){
            // device.getName() : 단말기의 Bluetooth Adapter 이름을 반환
            listItem.add(device.getName());
        }
        listItem.add("취소"); // 취소항목 추가

        //CharSequence : 변경 가능한 문자열
        //to Array : List 형태로 넘어온 것 배열로 바꿔서 처리하기 위한 toArray()함수
        final CharSequence[] items = listItem.toArray(new CharSequence[listItem.size()]);
        // toArray 함수를 이용해서 size만큼 배열이 생성 되었다.
        listItem.toArray(new CharSequence[listItem.size()]);

        builder.setItems(items, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int item) {
                if(item == mPariedDeviceCount){ //연결할 장치를 선택하지 않고 '취소'를 누른 경우
                    Toast.makeText(getApplicationContext(), "연결할 장치를 선택하지 않았습니다.", Toast.LENGTH_SHORT).show();
                }
                else{ //연결할 장피를 선택한 경우, 선택한 장치와 연결을 시도함
                    connectToSelectedDevice(items[item].toString());
                    mname.setText(items[item]);
                }
            }
        });

        AlertDialog alert = builder.create();
        alert.show();
    }

    void checkBluetooth() {
        /**
         * getDefaultAdapter() : 만일 폰에 블루투스 모듈이 없으면 null을 리턴한다
         *                       이 경우 Toast를 사용해 에러메시지를 표시하고 앱을 종료한다
         */
        mBluetoothAdapter = BluetoothAdapter.getDefaultAdapter();
        if(mBluetoothAdapter == null) { //블루투스 미지원
            Toast.makeText(getApplicationContext(), "기기가 블루투스를 지원하지 않습니다", Toast.LENGTH_SHORT).show();
            finish();
        }
        else{ //블루투스 지원
            /* isEnable() : 블루투스 모듈이 활성화 되었는지 확인.
                          true : 지원 false : 미지원
             */
            if(!mBluetoothAdapter.isEnabled()){ //블루투스를 지원하며 비활성 상태인 경우
                Toast.makeText(getApplicationContext(), "현재 블루투스가 비활성화 상태입니다", Toast.LENGTH_SHORT).show();
                Intent enableBtIntent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
                // REQUEST_ENABLE_BT : 블루투스 활성 상태의 변경 결과를 App으로 알려줄 때 식별자로 사용(0이상)
                /*
                starActivityForResult 함수 호출 후 다이얼로그가 나타남
                "예"를 선택하면 시스템의 블루투스 장치를 활성화 시키고
                "아니오"를 선택하면 비활성화 상태를 유지한다
                선택 결과는 onActivityResult 콜백 함수레서 확인할 수 있다
                 */
                startActivityForResult(enableBtIntent, REQUEST_ENABLE_BT);
            }
            else //블루투스 지원하며 활성 상태인 경우
                selectDevice();
        }
    }

    //onDestroy() : 어플이 종료될 때 호출되는 함수
    //             블루투스 연결이 필요하지 않는 경우 입출력 스트림 소켓을 닫아줌


    @Override
    protected void onDestroy() {
        try{
            mWorkerThread.interrupt(); //데이터 수신 쓰레드 종료
            mInputStream.close();
            mSocket.close();
        }catch(Exception e) {}
        super.onDestroy();
    }

    // onActivityResult: 사용자가 선택결과 확인(아니오, 예)
    //RESULT_OK : 블루투스가 활성화 상태로 변경된 경우 "예"
    //RESULT_CANCELED : 오류나 사용자의 "아니오" 선택으로 비활성 상태로 남아  있는 경우 RESULT_CANCELED

    /*
    사용자가 request를 허가(또는 거부)하면 안드로이드 앱의 onACtivityResult메소드를 호출해서 request의 허가/거부를 할수 있다
    첫번째 requestCode : startActivityResult에서 사용했던 요청 코드. RESULT_ENABLE_BT 값
    두번째 resultCode  : 종료된 액티비티가 setResult로 지정한 결과 코드. RESULT_OK, RESULT_CANCELED 값중 하나가 들어감
    세번째 data        : 종료된 액티비티가 인텐트를 첨부했을 경우, 그 인텐트가 들어있고 첨부가지 않으면 null
     */

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        //stratActivityForResult 를 여러번 사용할 땐 이런 식으로  swich문을 사용하여 어떤 요청인지 구분하여 사용
        switch (requestCode) {
            case REQUEST_ENABLE_BT:
                if (resultCode == RESULT_OK) { //블루투스 활성화 상태
                    selectDevice();
                } else if (requestCode == RESULT_CANCELED) { //블루투스 비활성화 상태 (종료)
                    Toast.makeText(getApplicationContext(), "블루투스를 사용할 수 없어 프로그램을 종효합니다", Toast.LENGTH_SHORT).show();
                    finish();
                }
                break;
        }
        super.onActivityResult(requestCode, resultCode, data);
    }
}