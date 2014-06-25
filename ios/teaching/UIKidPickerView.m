//
//  UIKidPickerView.m
//  teaching
//
//  Created by kidliuxu on 14-4-2.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "UIKidPickerView.h"

@implementation UIKidPickerView

@synthesize dataList, callback;

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self)
    {
        // Initialization code
    }
    return self;
}

//- (id)initWithData:(NSArray *) _dataList pickerViewDelegate:(id)_pickerViewDelegate
- (id)initWithFrame:(CGRect)frame pickerViewData:(NSArray *) _dataList
{
    self = [self initWithFrame:frame];
    if(self)
    {
        self.dataList = _dataList;
        [self initUIView];
    }
    return self;
}

- (void) initUIView
{
    [self setBackgroundColor:[UIColor grayColor]];

    UIButton *OKBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    [OKBtn setTitle:@"确认" forState:UIControlStateNormal];
    [OKBtn setFrame:CGRectMake(240, 0, 80, 40)];
    [OKBtn addTarget:self action:@selector(didOKBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
    [self addSubview:OKBtn];

    UIButton *CancelBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    [CancelBtn setTitle:@"取消" forState:UIControlStateNormal];
    [CancelBtn setFrame:CGRectMake(0, 0, 80, 40)];
    [CancelBtn addTarget:self action:@selector(didCancelBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
    [self addSubview:CancelBtn];

    UIPickerView *tmpPickerView = [[UIPickerView alloc] initWithFrame:CGRectZero];
    [tmpPickerView setFrame:CGRectMake(0, 40, tmpPickerView.frame.size.width, tmpPickerView.frame.size.height)];
    tmpPickerView.dataSource = self;
    tmpPickerView.delegate = self;
    tmpPickerView.showsSelectionIndicator = YES;
    [self addSubview:tmpPickerView];

    self.pickerView = tmpPickerView;
    [tmpPickerView release];
    
}

//pickerView 数据源与代理实现
-(NSInteger)numberOfComponentsInPickerView:(UIPickerView *)pickerView
{
    return 1;
}

- (NSInteger)pickerView:(UIPickerView *)pickerView numberOfRowsInComponent:(NSInteger)component

{
    return [self.dataList count];  //数组个数

}

- (UIView *)pickerView:(UIPickerView *)pickerView viewForRow:(NSInteger)row forComponent:(NSInteger)component reusingView:(UIView *)view
{
    UILabel *myView = nil;
    if (component == 0)
    {
        myView = [[[UILabel alloc] initWithFrame:CGRectMake(0.0, 0.0, 100, 30)] autorelease];
        myView.textAlignment = UITextAlignmentCenter;
        myView.text = [self.dataList objectAtIndex:row];
        myView.font = [UIFont systemFontOfSize:14];         //用label来设置字体大小
        myView.backgroundColor = [UIColor clearColor];
    }
    /*
     else
     {
     myView = [[[UILabel alloc] initWithFrame:CGRectMake(0.0, 0.0, 180, 30)] autorelease];
     myView.text = [pickerPlaceArray objectAtIndex:row];
     myView.textAlignment = UITextAlignmentCenter;
     myView.font = [UIFont systemFontOfSize:14];
     myView.backgroundColor = [UIColor clearColor];
     }
     */

    return myView;

}

- (CGFloat)pickerView:(UIPickerView *)pickerView rowHeightForComponent:(NSInteger)component
{
    return 40.0;
}

- (void) didOKBtnClicked:(id)sender
{
    NSLog(@"did ok");
    NSInteger row =[self.pickerView selectedRowInComponent:0];
    //NSString *selected = [self.dataList objectAtIndex:row];
    //NSLog(@"selfected is : %@", selected);
    if(self.callback)
    {
        //[self.callback didChoosePicker:row];
        if(row >= 0)
        {
            [self.callback didChoosePicker:row];
        }
    }
    [self removeFromSuperview];
}

- (void)didCancelBtnClicked:(id)sender
{
    NSLog(@"did cancel");
    [self removeFromSuperview];
}

- (void)setDefaultPickerSelectByID:(int)selectID
{
    [self.pickerView selectRow:selectID inComponent:0 animated:YES];
}

/*
- (void) setCallbackDelegate:(id<UIKidPickerViewDelegate>) callbacDdelegate
{
    if (callbacDdelegate)
    {
        self.callback = callbacDdelegate;
    }
}
*/
/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/

@end
